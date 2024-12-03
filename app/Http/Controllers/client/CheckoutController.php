<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PaymentController;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
// use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    //
    public function viewCheckout()
    {

        $user = Auth::user();
        if ($user !== null) {
            $cart = Cart::with('cartItems.productVariant')->where('user_id', $user->id)->first();
            if ($cart) {
                $totalPrice = $cart->cartItems->sum(function ($item) {
                    return $item->quantity * $item->productVariant->product->price;
                });
                return view('client.checkout', compact('user', 'cart', 'totalPrice'));
            } else {
                return view('client.checkout', compact('user', 'cart'));
            }
        } else {
            return view('client.checkout', compact('user'));
        }
    }
    public function thankyou()
    {
        return view('client.thankyou');
    }
}
