<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    //Hiển thị giỏ hàng
    public function index(){
        $cart = Cart::where('user_id', auth()->id())
                    ->where('status', 1)
                    ->with('cartItems.productVariant.product') // Eager load để lấy thông tin sản phẩm
                    ->first();

                    // if (!$cart) {
                    //     return redirect()->back()->with('error', 'Giỏ hàng không tồn tại.');
                    // }
                    // else{
                    if($cart){
                        $totalPrice = $cart->cartItems->sum(function ($item) {
                            return $item->quantity * $item->productVariant->price;
                        });
                        return view('client.cart', compact('cart','totalPrice'));

                    }else{
                        return view('client.cart', compact('cart'));
                    }


    }
    public function addToCart(Request $request)
    {
        //lấy các thông tin từ form lên để so sánh với product_variant
        $productId = $request -> input('product_id');
        $colorId = $request -> input('color_id');
        $sizeId = $request -> input('size_id');

        // sau đó tìm theo product_variant
        $productVariant = ProductVariant::where('product_id',$productId)
                                        ->where('color_id',$colorId)
                                        ->where('size_id',$sizeId)
                                        ->first();
        if(!$productVariant){
            return redirect()->back()->with('error','Biến thể không tồn tại');
        }

        // sau khi so sánh xong thì kiểm tra nếu người dùng đã có giỏ hàng thì load giỏ hàng theo user_id
        $cart = Cart::firstOrCreate(
            ['user_id'=>auth()->id(),'status' => 1],
            ['created_at'=>now(),'updated_at'=>now()]
        );

        // kiểm tra nếu có cartItem thì tiến hành cập nhật ở bước thứ 2
        $cartItem = CartItem::where('cart_id',$cart->id)
                            ->where('product_variant_id',$productVariant->id)
                            ->first();
        // bước thứ 2
        if($cartItem){
            // nếu sản phẩm đã có , cập nhật số lượng
            $cartItem->update([
                'quantity'=>$cartItem->quantity + 1,
                'updated_at' => now()
            ]);

        }else{
            // nếu chưa có sản phẩm thì tiến hành thêm mới
            CartItem::create([
                'cart_id' => $cart->id,
                'product_variant_id' => $productVariant -> id,
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        // tính tổng tiền
        return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng');
    }

    // Xoá sản phẩm khỏi giỏ
    public function remove($id)
    {
        // tìm tới item để xoá theo id
        $cartItem = CartItem::findOrFail($id);
        // sau khi tìm xong tiến hành xoá
        $cartItem->delete();
        return redirect()->route('cart.load')->with('success','Sản phẩm đã được xoá khỏi giỏ hàng');
    }

    // Thanh toán giỏ hàng
    public function checkout()
    {

    }
}


