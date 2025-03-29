<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use App\Models\Cart;

abstract class Controller
{
    public function __construct()
    {
        View::composer('*', function ($view) {
            $cartCount = 0;
            if (auth()->check()) {
                $cart = Cart::with('items')->where('user_id', auth()->id())->first();
                $cartCount = $cart ? $cart->items->sum('quantity') : 0;
            }
            $view->with('cartCount', $cartCount);
        });
    }
}
