<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Instruments;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // GET /cart => cart.index
    public function index()
    {
        // Retrieve the cart with related instruments for the authenticated user.
        $cart = Cart::with('items.instrument')->where('user_id', auth()->id())->first();
        $cartItems = $cart ? $cart->items : [];
        return view('pages.cart.show', compact('cartItems'));
    }

    // POST /cart/add/{id} => cart.add
    public function addToCart(Request $request, $id)
    {
        $product = Instruments::findOrFail($id);

        // Create or retrieve the cart for the current user.
        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);

        // Check if the product is already in the cart.
        $cartItem = $cart->items()->where('instrument_id', $product->id)->first();

        if ($cartItem) {
            // Increment quantity and update rental dates.
            $cartItem->increment('quantity');
            $cartItem->update([
                'rental_start_date' => $request->input('start_date'),
                'rental_end_date'   => $request->input('end_date'),
            ]);
        } else {
            // Create new cart item with quantity set to 1.
            $cartItem = $cart->items()->create([
                'instrument_id'     => $product->id,
                'quantity'          => 1,
                'rental_start_date' => $request->input('start_date'),
                'rental_end_date'   => $request->input('end_date'),
            ]);
        }

        return redirect()->back()->with('success', $product->name . ' added to cart!');
    }

    // PUT /cart/update/{id} => cart.update
    public function update(Request $request, $id)
    {
        $cartItem = CartItem::findOrFail($id);
        $cartItem->update([
            'quantity' => $request->input('quantity')
        ]);

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully!');
    }

    // DELETE /cart/remove/{id} => cart.remove
    public function remove($id)
    {
        $cartItem = CartItem::findOrFail($id);
        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Item removed from cart!');
    }

    // PUT /cart/updateDate/{id} => cart.updateDate
    public function updateDate(Request $request, $id)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        $cartItem = CartItem::findOrFail($id);
        $cartItem->update([
            'rental_start_date' => $request->input('start_date'),
            'rental_end_date'   => $request->input('end_date'),
        ]);

        return redirect()->back()->with('success', 'Rental period updated successfully!');
    }
}
