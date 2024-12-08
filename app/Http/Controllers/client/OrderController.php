<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\mailOrder;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\FlashSaleItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function Order(Request $request)
{
    $user = Auth::user();

    $cart = Cart::with('cartItems.productVariant.product')->where('user_id', $user->id)->first();

    if (!$cart || $cart->cartItems->isEmpty()) {
        return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống.');
    }

    // Lấy danh sách các mục giỏ hàng được chọn
    $selectedCartItemIds = $request->input('selectedCartItemIds', []);
    $selectedCartItems = $cart->cartItems->whereIn('id', $selectedCartItemIds);

    if ($selectedCartItems->isEmpty()) {
        return redirect()->route('cart.load')->with('error', 'Không có sản phẩm nào được chọn để đặt hàng.');
    }

    // Kiểm tra sản phẩm ngừng kinh doanh
    $inactiveItems = $selectedCartItems->filter(function ($cartItem) {
        return $cartItem->productVariant->product->status == 2;
    });

    if ($inactiveItems->count() > 0) {
        $inactiveProductNames = $inactiveItems->pluck('productVariant.product.name')->join(', ');
        return redirect()->route('cart.load')->with('error', 'Các sản phẩm sau đã ngừng kinh doanh: ' . $inactiveProductNames . '. Vui lòng xoá chúng khỏi giỏ hàng.');
    }

    // Tính tổng tiền
    $totalPrice = $selectedCartItems->sum(function ($cartItem) {
        $flashSaleItem = FlashSaleItem::where('product_id', $cartItem->productVariant->product->id)
            ->whereHas('flashSale', function ($query) {
                $query->where('start_time', '<=', now())
                    ->where('end_time', '>=', now())
                    ->where('status', 'active');
            })
            ->first();

        $finalPrice = $flashSaleItem ? $flashSaleItem->price : $cartItem->productVariant->product->price;

        return $finalPrice * $cartItem->quantity;
    });

    // Validate thông tin đơn hàng
    $validate = $request->validate([
        'name_order' => 'required|string|max:255',
        'phone_order' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|max:15',
        'address_order' => 'required|string|min:10|max:500',
    ], [
        'name_order.required' => 'Vui lòng nhập tên người đặt hàng.',
        'phone_order.required' => 'Vui lòng nhập số điện thoại.',
        'address_order.required' => 'Vui lòng nhập địa chỉ.',
    ]);

    // Tạo đơn hàng
    $order = Order::create([
        'user_id' => $user->id,
        'payment' => 1,
        'order_date' => now(),
        'status' => 'Chờ xác nhận',
        'total_amount' => $totalPrice + 30000,
        'name_order' => $request->name_order,
        'phone_order' => $request->phone_order,
        'address_order' => $request->address_order,
        'content_order' => $request->content_order,
    ]);

    // Tạo các mục đơn hàng
    foreach ($selectedCartItems as $item) {
        $productVariant = $item->productVariant;

        if (!$productVariant) {
            return redirect()->back()->with('error', 'Sản phẩm không tồn tại hoặc không có sẵn.');
        }

        // Kiểm tra số lượng tồn kho
        if ($productVariant->stock_quantity < $item->quantity) {
            return redirect()->back()->with('error', 'Sản phẩm ' . $productVariant->product->name . ' không đủ số lượng trong kho.');
        }

        // Trừ số lượng tồn kho
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
            'order_id' => $order->id,
            'product_variant_id' => $productVariant->id,
            'quantity' => $item->quantity,
            'price' => $finalPrice,
        ]);
    }

    // Xóa các mục đã mua khỏi giỏ hàng
    $selectedCartItemIds = $request->input('selectedCartItemIds', []);

    // Xóa các sản phẩm đã được chọn khỏi giỏ hàng
    $cart->cartItems()->whereIn('id', $selectedCartItemIds)->delete();

    // Nếu giỏ hàng không còn sản phẩm nào, xóa luôn giỏ hàng
    if ($cart->cartItems()->count() === 0) {
        $cart->delete();
    }
        $order_item = OrderItem::where('order_id', $order->id)->get();
        Mail::to($user->email)->send(new mailOrder($order, $order_item));
    return redirect()->route('thankyou');
}

    public function loadOrderUser(){
        $user = Auth::user();
        $orders = Order::where('user_id',$user->id)->with('orderItems')->orderBy('id', 'desc')->get();
        $orders_pending = Order::where('user_id', $user->id)->where('status', 'Chờ xác nhận')->with('orderItems')->orderBy('id', 'desc')->get(); // Chờ thanh toán
        $orders_vanchuyen = Order::where('user_id', $user->id)->where('status', 'Vận chuyển')->with('orderItems')->orderBy('id', 'desc')->get(); // Hoàn thành
        $orders_chogiaohang = Order::where('user_id', $user->id)->where('status', 'Chờ giao hàng')->with('orderItems')->orderBy('id', 'desc')->get(); // Đã hủy
        $orders_hoanthanh = Order::where('user_id', $user->id)->where('status', 'Hoàn thành')->with('orderItems')->orderBy('id', 'desc')->get(); // Đã hủy
        $orders_dahuy = Order::where('user_id', $user->id)->where('status', 'Đã huỷ')->with('orderItems')->orderBy('id', 'desc')->get(); // Đã hủy
        $orders_danhan = Order::where('user_id', $user->id)->where('status', 'Đã nhận hàng')->with('orderItems')->orderBy('id', 'desc')->get(); // Đã hủy
        return view('client.order',compact('orders_dahuy','orders_pending','orders_vanchuyen','orders_chogiaohang','orders_hoanthanh','orders_danhan','orders'));
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

public function cancelOrder($orderId, Request $request)
{
    $order = Order::where('user_id', auth()->id())
                  ->where('id', $orderId)
                  ->first();

    if ($order) {
        // Nếu đơn hàng đã được xác nhận (status = 'confirmed'), không cho phép huỷ
        if ($order->status == 'Vận chuyển') {
            return redirect()->route("orders.loadUser")->with('error_' . $order->id, 'Không thể huỷ đơn hàng đã vận chuyển .');
        }
        if ($order->status == 'Chờ giao hàng') {
            return redirect()->route("orders.loadUser")->with('error_' . $order->id, 'Không thể huỷ đơn hàng chờ giao tới bạn .');
        }
        if ($order->status == 'Hoàn thành') {
            return redirect()->route("orders.loadUser")->with('error_' . $order->id, 'Không thể huỷ đơn hàng đã hoàn thành .');
        }

        $order->status = 'Đã huỷ';
        $order->save();

        return redirect()->route('orders.loadUser')->with('success', 'Đơn hàng đã được hủy.');
    }

    return redirect()->route("orders.loadUser")->with('error', 'Không thể hủy đơn hàng này.');
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

    public function reorder($orderId)
{
    $order = Order::find($orderId);

    // Kiểm tra nếu đơn hàng tồn tại
    if ($order) {
        // Tạo hoặc lấy giỏ hàng của người dùng
        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);

        // Lặp qua các sản phẩm trong đơn hàng và thêm chúng vào giỏ hàng
        foreach ($order->orderItems as $item) {
            // Kiểm tra nếu sản phẩm đã có trong giỏ hàng
            $existingItem = CartItem::where('cart_id', $cart->id)
                                    ->where('product_variant_id', $item->productVariant->id)
                                    ->first();

            if ($existingItem) {
                // Nếu sản phẩm đã có trong giỏ hàng, chỉ cần tăng số lượng lên
                $existingItem->quantity += $item->quantity;
                $existingItem->save();
            } else {
                // Nếu chưa có, tạo mới item trong giỏ hàng
                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_variant_id' => $item->productVariant->id,
                    'quantity' => $item->quantity,
                    'price' => $item->productVariant->product->price,
                ]);
            }
        }

        return redirect()->route('cart.load')->with('success', 'Đã thêm các sản phẩm vào giỏ hàng.');
    }

    return redirect()->route('orders.loadUser')->with('error', 'Đơn hàng không tồn tại.');
}



}