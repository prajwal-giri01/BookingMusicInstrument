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
use Illuminate\Support\Facades\Mail;
use Throwable;

class KhaltiPaymentController extends Controller
{
    public function purchase(Request $request)
    {
        try {
            $data = $request->validate([
                'delivery_address' => 'required|string|max:255',
                'street' => 'required|string|max:255',
                'ward' => 'required|string|max:100',
                'city' => 'required|string|max:100',
                'district' => 'required|string|max:100',
                'province' => 'required|string|max:100',
                'postal_code' => 'required|string|max:20',
                'service_id' => 'nullable',
                'name' => 'required|string',
                'amount' => 'required|numeric',
                'user' => 'required|exists:users,id',
            ]);

            // Check if it's a direct package checkout (no cart)
            $directPackage = session('direct_checkout');
            $cart = Cart::where('user_id', $data['user'])->with('items.instrument')->first();

            if ((!$cart || $cart->items->isEmpty()) && !$directPackage) {
                return response()->json(['error' => 'Your cart is empty.'], 400);
            }

            // Create a virtual cart object if package checkout
            if (!$cart || $cart->items->isEmpty()) {
                $cart = (object)[
                    'items' => collect($directPackage['instruments'])->map(function ($instrument) use ($directPackage) {
                        return (object)[
                            'instrument' => (object)[
                                'id' => $instrument['id'],
                                'name' => $instrument['name'],
                                'price' => $instrument['price'],
                                'rental_price' => $instrument['price'],
                                'stock_quantity' => 100
                            ],
                            'quantity' => $directPackage['quantity'],
                            'rental_start_date' => $directPackage['rental_start_date'],
                            'rental_end_date' => $directPackage['rental_end_date'],
                        ];
                    })
                ];
            }

            // Stock check (real or virtual cart)
            foreach ($cart->items as $item) {
                if (!$item->instrument || $item->instrument->stock_quantity < $item->quantity) {
                    return response()->json([
                        'error' => "Not enough stock for instrument: {$item->instrument->name}"
                    ], 422);
                }
            }

            // ✅ Create order
            $order = Order::create([
                'user_id' => $data['user'],
                'total_rental_cost' => $data['amount'],
                'payment_status' => 'pending',
                'rental_status' => 'unconfirmed',
                'delivery_address' => $data['delivery_address'],
                'street' => $data['street'],
                'ward' => $data['ward'],
                'city' => $data['city'],
                'district' => $data['district'],
                'province' => $data['province'],
                'postal_code' => $data['postal_code'],
            ]);
            if ($directPackage) {
                foreach ($directPackage['instruments'] as $instrumentData) {
                    $instrument = \App\Models\Instruments::find($instrumentData['id']);

                    $order->orderItems()->create([
                        'instrument_id'     => $instrument->id,
                        'quantity'          => $directPackage['quantity'],
                        'rental_start_date' => $directPackage['rental_start_date'],
                        'rental_end_date'   => $directPackage['rental_end_date'],
                        'price'             => $instrument->rental_price,
                    ]);
                }
            }


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

        } catch (Throwable $e) {
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
        $cart = Cart::where('user_id', $userId)->with('items.instrument')->first();
        $directPackage = session('direct_checkout');

        if ((!$cart || $cart->items->isEmpty()) && !$directPackage) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        DB::beginTransaction();
        try {
            if ($directPackage) {

                $order->update([
                    'payment_status' => 'paid',
                    'rental_status' => 'ongoing',
                ]);

                session()->forget('direct_checkout');

                try {
                    Mail::to($order->user->email)->queue(new \App\Mail\InvoiceMail($order));
                } catch (\Exception $e) {
                    Log::warning("Failed to send invoice email: " . $e->getMessage());
                }

                DB::commit();
                return redirect()->route('order.confirmation', $order->id)
                    ->with('success', 'Your package order has been confirmed!');
            }

            foreach ($cart->items as $item) {
                if (!$item->rental_start_date || !$item->rental_end_date) {
                    return redirect()->back()->with('error', 'Please set rental dates for all items.');
                }

                $instrument = $item->instrument;

                if ($instrument->stock_quantity < $item->quantity) {
                    throw new \Exception("Not enough stock for instrument: {$instrument->name}");
                }

                $instrument->decrement('stock_quantity', $item->quantity);

                $order->orderItems()->create([
                    'instrument_id' => $instrument->id,
                    'quantity' => $item->quantity,
                    'rental_start_date' => $item->rental_start_date,
                    'rental_end_date' => $item->rental_end_date,
                    'price' => $instrument->rental_price,
                ]);
            }

            $order->update([
                'payment_status' => 'paid',
                'rental_status' => 'ongoing',
            ]);

            try {
                $cart->items()->delete();
            } catch (\Exception $e) {
                CartItem::where('cart_id', $cart->id)->delete();
            }

            try {
                Mail::to($order->user->email)->queue(new \App\Mail\InvoiceMail($order));
            } catch (\Exception $e) {
                Log::warning("Invoice email failed: " . $e->getMessage());
            }

            DB::commit();
            return redirect()->route('order.confirmation', $order->id)
                ->with('success', 'Your order has been confirmed and paid successfully.');

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
