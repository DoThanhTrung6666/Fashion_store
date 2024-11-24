<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
// use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    //
    public function viewCheckout(){

        $user=Auth::user();
        if($user !== null){
            $cart = Cart::with('cartItems.productVariant')->where('user_id',$user->id)->first();
            if($cart){
                $totalPrice = $cart->cartItems->sum(function ($item) {
                    return $item->quantity * $item->productVariant->product->price;
                });
                return view('client.checkout',compact('user','cart','totalPrice'));
            }else{
                return view('client.checkout',compact('user','cart'));
            }
        }else{
            return view('client.checkout',compact('user'));
        }

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
