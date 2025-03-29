<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Instruments;
use App\Models\Order;
use App\Models\Drinks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function addToCart(Request $request, $id)
    {
        // Find the product
        $product = Instruments::findOrFail($id);

        // Get the cart for the logged-in user, or create one if it doesn't exist
        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);

        // Add or update the item in the cart
        $cartItem = $cart->items()->updateOrCreate(
            ['instrument_id' => $product->id],
            [
                'quantity' => DB::raw('quantity + 1'),
                'rental_start_date' => $request->input('start_date'),
                'rental_end_date' => $request->input('end_date'),
            ]
        );
        return redirect()->back()->with('success', $product->name . ' added to cart!');
    }

    public function showCart()
    {
        // Retrieve the cart with related products
        $cart = Cart::with('items.instrument')->where('user_id', auth()->id())->first();
        // Return an empty array if the cart is not found
        $cartItems = $cart ? $cart->items : [];
        return view('pages.cart.show', compact('cartItems'));
    }

    public function updateCart(Request $request, $id)
    {
        $cartItem = CartItem::findOrFail($id);
        $cartItem->update(['quantity' => $request->quantity]);

        return redirect()->route('cart.show')->with('success', 'Cart updated successfully!');
    }
    public function removeFromCart($id)
    {
        $cartItem = CartItem::findOrFail($id);
        $cartItem->delete();

        return redirect()->route('cart.show')->with('success', 'Item removed from cart!');
    }
    public function updateDate(Request $request, $id)
    {
        // Validate dates
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Find the cart item and update dates
        $cartItem = CartItem::findOrFail($id);
        $cartItem->rental_start_date = $request->input('start_date');
        $cartItem->rental_end_date = $request->input('end_date');
        $cartItem->save();

        return redirect()->back()->with('success', 'Rental period updated successfully!');
    }


}

