<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', auth()->id())->with('items.instrument')->first();
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }
        return view('pages.checkout', compact('cart'));
    }

    public function store(Request $request)
    {
        $cart = Cart::where('user_id', auth()->id())->with('items.instrument')->first();

        foreach ($cart->items as $item) {
            if (!$item->rental_start_date || !$item->rental_end_date) {
                return redirect()->back()->with('error', 'Please set valid rental dates for all items.');
            }
        }

        // Create the order
        $order = Order::create([
            'user_id'          => auth()->id(),
            'total_rental_cost'=> $cart->items->sum(function ($item) {
                return $item->instrument->rental_price * $item->quantity;
            }),
            'status'           => 'pending',
        ]);


        foreach ($cart->items as $item) {
            $order->cartItems()->create([
                'instrument_id'     => $item->instrument->id,
                'quantity'          => $item->quantity,
                'rental_start_date' => $item->rental_start_date,
                'rental_end_date'   => $item->rental_end_date,
                'price'             => $item->instrument->rental_price,
            ]);
        }


        $cart->items()->delete();

        return redirect()->route('order.confirmation', $order->id)
            ->with('success', 'Your order has been placed successfully!');
    }
}
