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
                return $item->quantity * $item->productVariant->product->price;
            });
        }

        // tạo đơn hàng mới
        $order = Order::create([
            'user_id' => $user->id,
            'payment' => 1,
            'order_date'=> now(),
            'status' => 'Chờ xác nhận',
            'total_amount' => $totalPrice
        ]);
        // tạo các mục đơn hàng từ giỏ hàng
        foreach($cart->cartItems as $item){
            if (!$item->productVariant) {
                return redirect()->back()->with('error', 'Sản phẩm không tồn tại hoặc không có sẵn.');
            }
             // Cập nhật số lượng tồn kho của biến thể sản phẩm
                    $productVariant = $item->productVariant;

                    // Kiểm tra xem số lượng tồn kho có đủ không
                    if ($productVariant->stock_quantity < $item->quantity) {
                        return redirect()->back()->with('error', 'Sản phẩm ' . $productVariant->product->name . ' không đủ số lượng trong kho.');
                    }

                    // Trừ số lượng của biến thể sản phẩm
                    $productVariant->stock_quantity -= $item->quantity;
                    $productVariant->save();
            OrderItem::create([
                'order_id'=>$order->id,
                // dd($item->product_variant_id),
                'product_variant_id'=>$item->productVariant->id,
                'quantity'=>$item->quantity,
                'price'=>$item->productVariant->product->price
            ]);
        }
        // xoá giỏ hàng khi mua thành công
        $cart->cartItems()->delete();
        $cart->delete();

        return redirect()->route('thankyou');
    }
    public function loadOrderUser(){
        $user = Auth::user();
        $orders = Order::where('user_id',$user->id)->with('orderItems')->get();
        return view('client.order',compact('orders'));
    }
    // OrderController.php
public function show($orderId)
{
    $order = Order::with(['orderItems.productVariant.size', 'orderItems.productVariant.color'])
        ->where('user_id', auth()->id())
        ->where('id', $orderId)
        ->first();

    return view('client.orderdetail', compact('order'));
}

public function cancelOrder($orderId)
{
    $order = Order::where('user_id', auth()->id())
                  ->where('id', $orderId)
                  ->first();

    if ($order) {
        $order->status = 'Hủy đơn hàng';
        $order->save();

        return redirect()->route('orders.loadUser')->with('success', 'Đơn hàng đã được hủy.');
    }

    return redirect()->route('orders.loadUser')->with('error', 'Không thể hủy đơn hàng này.');
}


}
