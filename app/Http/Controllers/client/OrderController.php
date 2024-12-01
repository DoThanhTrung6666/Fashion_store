<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\FlashSaleItem;
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
        $totalPrice = $cart->cartItems->sum(function ($cartItem) {
            // Lấy thông tin Flash Sale nếu có
            $flashSaleItem = FlashSaleItem::where('product_id', $cartItem->productVariant->product->id)
                ->whereHas('flashSale', function ($query) {
                    $query->where('start_time', '<=', now())
                        ->where('end_time', '>=', now())
                        ->where('status', 'active');
                })
                ->first();

            // Sử dụng giá giảm nếu có Flash Sale, nếu không dùng giá gốc
            $finalPrice = $flashSaleItem ? $flashSaleItem->price : $cartItem->productVariant->product->price;

            // Tính giá theo số lượng sản phẩm
            return $finalPrice * $cartItem->quantity;
        });
        }

        // tạo đơn hàng mới
        $order = Order::create([
            'user_id' => $user->id,
            'payment' => 1,
            'order_date'=> now(),
            'status' => 'Chờ xác nhận',
            'total_amount' => $totalPrice + 30000
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
                    $flashSaleItem = FlashSaleItem::where('product_id', $productVariant->product->id)
                    ->whereHas('flashSale', function ($query) {
                        $query->where('start_time', '<=', now())
                            ->where('end_time', '>=', now())
                            ->where('status', 'active');
                    })
                    ->first();

                    $finalPrice = $flashSaleItem ? $flashSaleItem->price : $productVariant->product->price;

        // Tạo mục đơn hàng
            OrderItem::create([
                'order_id'=>$order->id,
                // dd($item->product_variant_id),
                'product_variant_id'=>$item->productVariant->id,
                'quantity'=>$item->quantity,
                'price'=>$finalPrice
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


// xử lí mua lại
public function repurchase($orderId)
    {
        $user = Auth::user(); // Lấy thông tin người dùng đang đăng nhập

        // Lấy đơn hàng đã huỷ mà người dùng muốn mua lại
        $oldOrder = Order::with('orderItems.productVariant')->where('id', $orderId)->where('user_id', $user->id)->first();

        // Nếu không tìm thấy đơn hàng
        if (!$oldOrder) {
            return redirect()->back()->with('error', 'Đơn hàng không tìm thấy.');
        }

        // Kiểm tra nếu đơn hàng cũ không phải là "Đã huỷ"
        if ($oldOrder->status !== 'Hủy đơn hàng') {
            return redirect()->back()->with('error', 'Đơn hàng này không thể mua lại vì trạng thái không phải là "Đã huỷ".');
        }

        // Kiểm tra số lượng tồn kho của sản phẩm trong đơn hàng cũ
        foreach ($oldOrder->orderItems as $item) {
            $productVariant = $item->productVariant;

            // Kiểm tra số lượng tồn kho của sản phẩm
            if ($productVariant->stock_quantity < $item->quantity) {
                return redirect()->back()->with('error', 'Sản phẩm ' . $productVariant->product->name . ' không đủ số lượng trong kho.');
            }
        }

        // Cập nhật trạng thái đơn hàng từ "Đã huỷ" thành "Chờ xác nhận"
        $oldOrder->status = 'Chờ xác nhận';
        $oldOrder->save();

        // Thông báo thành công và chuyển đến trang cảm ơn hoặc trang chi tiết đơn hàng
        return redirect()->back()->with('success', 'Đơn hàng của bạn đã được khôi phục và đang chờ xác nhận.');
    }


}
