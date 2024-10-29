<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function Order(){
        $user = Auth::user();
        $cart = Cart::with('cartItems.productVariant')->where('user_id',$user->id)->first();

        // kiểm tra xem giỏ hàng có rỗng không
        // if(!$cart || $cart->cartItems->isEmpty()){
        //     return redirect()->back()->with('error','Giỏ hàng của bạn đang trống.');
        // }

        if($cart){
        // tính tổng tiền
            $totalPrice = $cart->cartItems->sum(function ($item) {
                return $item->quantity * $item->productVariant->price;
            });
        }

        // tạo đơn hàng mới
        $order = Order::create([
            'user_id' => $user->id,
            'payment' => 1,
            'order_date'=> now(),
            'status' => 'Đơn hàng mới',
            'total_amount' => $totalPrice
        ]);
        // tạo các mục đơn hàng từ giỏ hàng
        foreach($cart->cartItems as $item){
            if (!$item->productVariant) {
                return redirect()->back()->with('error', 'Sản phẩm không tồn tại hoặc không có sẵn.');
            }
            OrderItem::create([
                'order_id'=>$order->id,
                // dd($item->product_variant_id),
                'product_variant_id'=>$item->productVariant->id,
                'quantity'=>$item->quantity,
                'price'=>$item->productVariant->price
            ]);
        }
        // xoá giỏ hàng khi mua thành công
        $cart->cartItems()->delete();
        $cart->delete();

        return redirect()->route('thankyou');
    }
}
