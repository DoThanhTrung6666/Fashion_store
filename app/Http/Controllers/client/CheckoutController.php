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
    // public function viewCheckout(Request $request)
    // {
    //     $user = Auth::user();

    //     if ($user === null) {
    //         return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để thanh toán.');
    //     }

    //     $selectedCartItemIds = $request->query('selectedCartItemIds', []);

    //     $cart = Cart::with('cartItems.productVariant.product')
    //         ->where('user_id', $user->id)->first();

    //     if (!$cart) {
    //         return redirect()->route('cart.load')->with('error', 'Giỏ hàng của bạn trống.');
    //     }

    //     $cartItems = $cart->cartItems->whereIn('id', $selectedCartItemIds);

    //     if ($cartItems->isEmpty()) {
    //         return redirect()->route('cart.load')->with('error', 'Không có sản phẩm nào được chọn.');
    //     }
    //     // Tính tổng số lượng của tất cả sản phẩm trong giỏ hàng
    //     // $totalQuantity = $cartItems->sum('quantity');
    //     $cartItemsWithSaleInfo = $cartItems->map(function ($cartItem) {
    //         $flashSale = FlashSaleItem::where('product_id', $cartItem->productVariant->product->id)
    //             ->whereHas('flashSale', function ($query) {
    //                 $query->where('start_time', '<=', now())
    //                     ->where('end_time', '>=', now())
    //                     ->where('status', 'Đang diễn ra');
    //             })
    //             ->first();
    //     // $cartItemsWithSaleInfo = $cartItems->map(function ($cartItem) use ($totalQuantity) {
    //     //     $flashSale = FlashSaleItem::where('product_id', $cartItem->productVariant->product->id)
    //     //         ->whereHas('flashSale', function ($query) {
    //     //             $query->where('start_time', '<=', now())
    //     //                 ->where('end_time', '>=', now())
    //     //                 ->where('status', 'Đang diễn ra');
    //     //         })
    //     //         ->first();

    //         $isOnFlashSale = $flashSale ? true : false;
    //         $flashSalePrice = $isOnFlashSale ? $flashSale->price : null;
    //         $originalPrice = $cartItem->productVariant->product->price;

    //         // Nếu số lượng là 2 sản phẩm trở lên, áp dụng giá gốc
    //         $finalPrice = $cartItem->quantity >= 2 ? $originalPrice : ($flashSalePrice ?? $originalPrice);
    //         // $status = $totalQuantity >= 2 ? $isOnFlashSale =false :true;
    //         return [
    //             'cartItem' => $cartItem,
    //             'isOnFlashSale' => $isOnFlashSale,
    //             'flashSale' => $flashSale,
    //             'finalPrice' => $finalPrice,
    //             // 'status' =>$status
    //         ];
    //     });

    //     $totalPrice = $cartItemsWithSaleInfo->sum(function ($item) {
    //         return $item['finalPrice'] * $item['cartItem']->quantity;
    //     });

    //     return view('client.checkout', compact('cartItemsWithSaleInfo', 'totalPrice', 'user'));
    // }

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
        foreach ($cartItems as $cartItem) {
            $product = $cartItem->productVariant->product;
            // dd($product);
            // // dd($product->status ==1);

            if ($product->status == 2) {
                return redirect()->back()->with('error', 'Sản phẩm ' . $product->name . 'đã ngừng bán . hãy xoá khỏi giỏ hàng');
            }
        }
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.load')->with('error', 'Không có sản phẩm nào được chọn.');
        }

        // Lấy sản phẩm đầu tiên có Flash Sale (ưu tiên áp dụng)
        $flashSaleCartItem = $cartItems->first(function ($cartItem) {
            return FlashSaleItem::where('product_id', $cartItem->productVariant->product->id)
                ->whereHas('flashSale', function ($query) {
                    $query->where('start_time', '<=', now())
                        ->where('end_time', '>=', now())
                        ->where('status', 'Đang diễn ra');
                })
                ->exists();
        });

        $cartItemsWithSaleInfo = $cartItems->map(function ($cartItem) use ($flashSaleCartItem) {
            $flashSale = null;
            $isOnFlashSale = false;
            $flashSalePrice = null;
            $flashSaleQuantity = 0;

            if ($flashSaleCartItem && $flashSaleCartItem->id === $cartItem->id) {
                // Lấy thông tin Flash Sale
                $flashSale = FlashSaleItem::where('product_id', $cartItem->productVariant->product->id)
                    ->whereHas('flashSale', function ($query) {
                        $query->where('start_time', '<=', now())
                            ->where('end_time', '>=', now())
                            ->where('status', 'Đang diễn ra');
                    })
                    ->first();

                $isOnFlashSale = $flashSale ? true : false;
                $flashSalePrice = $flashSale ? $flashSale->price : null;

                // Chỉ 1 sản phẩm được tính giá Flash Sale
                $flashSaleQuantity = min(1, $cartItem->quantity);
            }

            $originalPrice = $cartItem->productVariant->product->price;

            // Tính tổng giá sản phẩm:
            // - 1 sản phẩm áp dụng Flash Sale
            // - Các sản phẩm còn lại tính giá gốc
            $finalPrice = ($flashSaleQuantity * $flashSalePrice) + (($cartItem->quantity - $flashSaleQuantity) * $originalPrice);

            return [
                'cartItem' => $cartItem,
                'isOnFlashSale' => $isOnFlashSale,
                'flashSale' => $flashSale,
                'finalPrice' => $finalPrice,
            ];
        });

        $totalPrice = $cartItemsWithSaleInfo->sum(function ($item) {
            return $item['finalPrice'];
        });

        return view('client.checkout', compact('cartItemsWithSaleInfo', 'totalPrice', 'user'));
    }




    public function thankyou()
    {
        return view('client.thankyou');
    }
}
