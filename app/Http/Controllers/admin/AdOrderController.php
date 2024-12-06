<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdOrderController extends Controller
{



public function index() {
    $status = request('status', 'Chờ xác nhận');
    $orders = Order::orderBy('id','DESC')->where('status', $status)->paginate();


    return view('admin.orders.index', compact('orders'));
}






public function update(Order $order)
{
    // Lấy trạng thái từ request, mặc định là 'chờ xác nhận'
    $status = request('status', 'Chờ xác nhận');

    // Kiểm tra nếu đơn hàng chưa được giao
    if ($order->status != 'Đã giao hàng') {
        $order->update(['status' => $status]);

        // Điều hướng tùy theo trạng thái mới
        if ($status === 'Đã giao hàng') {
            return redirect()->route('admin.orders.index', ['status' => 'Đã giao hàng'])->with('ok', 'Cập nhật trạng thái thành công');
        } elseif ($status === 'Hủy đơn hàng') {
            return redirect()->route('admin.orders.index', ['status' => 'Hủy đơn hàng'])->with('ok', 'Đơn hàng đã được hủy');
        }
    }

    // Nếu đơn hàng đã giao, không cho phép cập nhật
    return redirect()->route('admin.orders.index')->with('no', 'Không thể cập nhật đơn hàng đã giao');
}


    public function show($id)
{



    // Fetch the order by ID
    $order = Order::with('user', 'orderItems')->findOrFail($id); // Include relationships like 'user' and 'items' if available

    // Pass the order data to the view
    return view('admin.orders.show', compact('order'));
}
}
