<?php

namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __invoke()
    {
        if (Cart::instance('cart')->count() == 0) {
            notify()->warning("Your cart is empty");
            return redirect()->route('home');
        }

        $cart = Cart::instance('cart');
        $user = auth()?->user();

        return view('checkout.index', compact('cart', 'user'));
    }
}
