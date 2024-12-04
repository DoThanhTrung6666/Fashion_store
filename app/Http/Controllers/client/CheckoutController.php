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

    // mua thẳng
//     public function index(Request $request)
// {
//     $productId = $request->input('product_id');
//     $colorId = $request->input('color_id');
//     $sizeId = $request->input('size_id');
//     $quantity = $request->input('quantity');

//     // Lấy thông tin sản phẩm
//     $product = Product::findOrFail($productId);

//     // Lấy variant của sản phẩm theo color_id và size_id
//     $selectedVariant = $product->variants()
//                                ->where('color_id', $colorId)
//                                ->where('size_id', $sizeId)
//                                ->first();

//     // Nếu không tìm thấy variant phù hợp
//     if (!$selectedVariant) {
//         return redirect()->route('product.detail', ['id' => $productId])->with('error', 'Sản phẩm không hợp lệ.');
//     }

//     // Tính toán tổng tiền
//     $totalAmount = $selectedVariant->price * $quantity;

//     // Trả về view checkout với các biến
//     return view('checkout', compact('product', 'selectedVariant', 'quantity', 'totalAmount'));
// }
}
