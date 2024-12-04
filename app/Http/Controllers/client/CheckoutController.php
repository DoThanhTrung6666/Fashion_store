<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PaymentController;
use App\Models\Cart;
use App\Models\CartItem;

use App\Models\Order;

use App\Models\FlashSaleItem;

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
            // Lấy giỏ hàng của người dùng
            $cart = Cart::with('cartItems.productVariant.product')->where('user_id', $user->id)->first();

            if ($cart) {
                // Kiểm tra Flash Sale cho từng sản phẩm trong giỏ hàng
                $cartItemsWithSaleInfo = $cart->cartItems->map(function ($cartItem) {
                    $flashSale = FlashSaleItem::where('product_id', $cartItem->productVariant->product->id)
                        ->whereHas('flashSale', function ($query) {
                            $query->where('start_time', '<=', now())
                                ->where('end_time', '>=', now())
                                ->where('status', 'active');
                        })
                        ->first();

                    return [
                        'cartItem' => $cartItem, // Sản phẩm trong giỏ hàng
                        'isOnFlashSale' => $flashSale ? true : false, // Trạng thái Flash Sale
                        'flashSale' => $flashSale, // Thông tin Flash Sale nếu có
                        'finalPrice' => $flashSale ? $flashSale->price : $cartItem->productVariant->product->price, // Giá sau giảm (nếu có)
                    ];
                });

                // Tổng giá trị đơn hàng (theo giá giảm nếu có)
                $totalPrice = $cartItemsWithSaleInfo->sum(function ($item) {
                    return $item['finalPrice'] * $item['cartItem']->quantity;
                });

                return view('client.checkout', compact('user', 'cart', 'cartItemsWithSaleInfo', 'totalPrice'));
            }

            return view('client.checkout', compact('user', 'cart'));
        }

        return view('client.checkout', compact('user'));
    }

    public function thankyou(){

        return view('client.thankyou');
    }
}
