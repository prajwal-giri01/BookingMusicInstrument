<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Show the checkout page with current cart items.
     */
    public function checkout()
    {
        $cart = Cart::where('user_id', auth()->id())
            ->with('items.instrument')
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        return view('pages.checkout', compact('cart'));
    }

    /**
     * Process the checkout and create an order.
     */
    // Within OrderController.php

    public function store(Request $request)
    {
        $cart = Cart::where('user_id', auth()->id())
            ->with('items.instrument')
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Validate rental dates and delivery location
        $request->validate([
            'delivery_address' => 'required|string|max:255',
            'latitude'         => 'required|numeric',
            'longitude'        => 'required|numeric',
        ]);

        foreach ($cart->items as $item) {
            if (!$item->rental_start_date || !$item->rental_end_date) {
                return redirect()->back()->with('error', 'Please set rental dates for all items.');
            }
        }

        $totalRentalCost = $cart->items->sum(function ($item) {
            return $item->instrument->rental_price * $item->quantity;
        });

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id'           => auth()->id(),
                'total_rental_cost' => $totalRentalCost,
                'payment_status'    => 'pending',
                'rental_status'     => 'ongoing',
                'delivery_address'  => $request->input('delivery_address'),
                'latitude'          => $request->input('latitude'),
                'longitude'         => $request->input('longitude'),
            ]);

            foreach ($cart->items as $item) {
                $order->orderItems()->create([
                    'instrument_id'     => $item->instrument->id,
                    'quantity'          => $item->quantity,
                    'rental_start_date' => $item->rental_start_date,
                    'rental_end_date'   => $item->rental_end_date,
                    'price'             => $item->instrument->rental_price,
                ]);
            }

            // Optionally, process payment here.

            $cart->items()->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Order could not be processed.');
        }

        return redirect()->route('order.confirmation', $order->id)
            ->with('success', 'Your order has been placed successfully!');
    }


    /**
     * Show the order confirmation page.
     */
    public function confirmation(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        return view('pages.order_confirmation', compact('order'));
    }

    /**
     * List orders for the current user.
     */
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
        return view('pages.orders.index', compact('orders'));
    }

    /**
     * Show details for a specific order.
     */
    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        return view('pages.orders.show', compact('order'));
    }

    public function cancel(Order $order)
    {
        // Ensure the authenticated user is the owner of the order.
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // You can add further conditions here to only allow cancellation if the order is in a cancellable state.
        if ($order->rental_status === 'cancelled') {
            return redirect()->route('order.show', $order->id)
                ->with('error', 'This order is already cancelled.');
        }

        // Update the rental status to cancelled.
        $order->update(['rental_status' => 'cancelled']);

        return redirect()->route('order.show', $order->id)
            ->with('success', 'Order cancelled successfully.');
    }

}
