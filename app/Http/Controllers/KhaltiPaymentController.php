<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class KhaltiPaymentController extends Controller
{
    public function purchase(Request $request)
    {
        try {
            $data = $request->validate([
                'delivery_address' => 'required|string|max:255',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'service_id' => 'nullable', // optional if you want to auto-generate
                'name' => 'required|string',
                'amount' => 'required|numeric',
                'user' => 'required|exists:users,id',
            ]);

            // Create a new order (pending)
            $order = Order::create([
                'user_id' => $data['user'],
                'total_rental_cost' => $data['amount'],
                'payment_status' => 'pending',
                'rental_status' => 'unconfirmed',
                'delivery_address' => $data['delivery_address'],
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
            ]);

            $totalAmount = $data['amount'] * 100;

            $payload = [
                "return_url" => url('/verify-payment') . '?order_id=' . $order->id,
                "website_url" => url('/'),
                "amount" => $totalAmount,
                "purchase_order_id" => $order->id,
                "purchase_order_name" => $data['name'],
                "customer_info" => [
                    "name" => "User #" . $data['user'],
                    "email" => auth()->user()->email ?? 'user@email.com',
                    "phone" => "9800000000"
                ]
            ];

            $response = Http::withoutVerifying()->withHeaders([
                'Authorization' => 'key ' . env('KHALTI_SECRET_KEY'),
                'Content-Type' => 'application/json',
            ])->post('https://dev.khalti.com/api/v2/epayment/initiate/', $payload);

            Log::info('Khalti Response:', $response->json());

            if ($response->successful() && isset($response['payment_url'])) {
                return response()->json(['khalti_url' => $response['payment_url']]);
            }

            return response()->json(['error' => 'Failed to initiate Khalti payment.'], 500);

        } catch (\Throwable $e) {
            Log::error('Khalti Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }


    public function verifyPayment(Request $request)
    {
        $orderId = $request->query('order_id');
        $order = Order::find($orderId);

        if (!$order) {
            Log::error('Order not found during verifyPayment. Order ID: ' . $orderId);
            return redirect()->route('cart.index')->with('error', 'Order not found.');
        }

        $userId = $order->user_id;

        $cart = Cart::where('user_id', $userId)
            ->with('items.instrument')
            ->first();

        if (!$cart) {
            Log::warning("No cart found for user ID: $userId");
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        if ($cart->items->isEmpty()) {
            Log::warning("Cart is empty for user ID: $userId");
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        DB::beginTransaction();
        try {
            foreach ($cart->items as $item) {
                if (!$item->rental_start_date || !$item->rental_end_date) {
                    Log::error("Missing rental dates for item ID: {$item->id}");
                    return redirect()->back()->with('error', 'Please set rental dates for all items.');
                }

                $order->orderItems()->create([
                    'instrument_id' => $item->instrument->id,
                    'quantity' => $item->quantity,
                    'rental_start_date' => $item->rental_start_date,
                    'rental_end_date' => $item->rental_end_date,
                    'price' => $item->instrument->rental_price,
                ]);
            }

            // Update the order payment and rental status
            $order->update([
                'payment_status' => 'paid',
                'rental_status' => 'ongoing',
            ]);

            // Try standard cart item deletion
            try {
                $cart->items()->delete();
                Log::info("Cart items deleted using relation method for user ID: $userId");
            } catch (\Exception $e) {
                Log::warning("Cart relation delete failed: " . $e->getMessage());

                // Fallback: use direct query
                CartItem::where('cart_id', $cart->id)->delete();
                Log::info("Fallback cart item deletion used for cart ID: " . $cart->id);
            }

            DB::commit();
            Log::info("Order confirmed and cart cleared successfully for user ID: $userId");

            return redirect()->route('order.confirmation', $order->id)
                ->with('success', 'Your order has been confirmed and paid!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Verify Payment Transaction Failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->with('error', 'Order could not be completed.');
        }
    }


}
