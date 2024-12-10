<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\FlashSaleItem;
use App\Models\Product;
// use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    //
    public function viewCheckout(Request $request)
    {
        $user = Auth::user();

        if ($user === null) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để thanh toán.');
        }

        $selectedCartItemIds = $request->query('selectedCartItemIds', []);

        $cart = Cart::with('cartItems.productVariant.product')
            ->where('user_id', $user->id)->first();

        if (!$cart) {
            return redirect()->route('cart.load')->with('error', 'Giỏ hàng của bạn trống.');
        }

        $cartItems = $cart->cartItems->whereIn('id', $selectedCartItemIds);

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.load')->with('error', 'Không có sản phẩm nào được chọn.');
        }

        $cartItemsWithSaleInfo = $cartItems->map(function ($cartItem) {
            $flashSale = FlashSaleItem::where('product_id', $cartItem->productVariant->product->id)
                ->whereHas('flashSale', function ($query) {
                    $query->where('start_time', '<=', now())
                        ->where('end_time', '>=', now())
                        ->where('status', 'active');
                })
                ->first();

            return [
                'cartItem' => $cartItem,
                'isOnFlashSale' => $flashSale ? true : false,
                'flashSale' => $flashSale,
                'finalPrice' => $flashSale ? $flashSale->price : $cartItem->productVariant->product->price,
            ];
        });

        $totalPrice = $cartItemsWithSaleInfo->sum(function ($item) {
            return $item['finalPrice'] * $item['cartItem']->quantity;
        });

        return view('client.checkout', compact('cartItemsWithSaleInfo', 'totalPrice', 'user'));
    }


    public function thankyou()
    {
        return view('client.thankyou');
    }
}
