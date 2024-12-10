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
    if ($order->status != 'Hoàn thành') {
        $order->update(['status' => $status]);

        // Điều hướng tùy theo trạng thái mới
        if ($status === 'Hoàn thành') {
            return redirect()->route('admin.orders.index', ['status' => 'Hoàn thành'])->with('ok', 'Cập nhật trạng thái thành công');
        } elseif ($status === 'Đã huỷ') {
            return redirect()->route('admin.orders.index', ['status' => 'Đã huỷ'])->with('ok', 'Đơn hàng đã được hủy');
        } elseif ($status === 'Vận chuyển') {
            return redirect()->route('admin.orders.index', ['status' => 'Vận chuyển'])->with('ok', 'Đơn hàng đã vận chuyển');
        } elseif ($status === 'Chờ giao hàng') {
            return redirect()->route('admin.orders.index', ['status' => 'Chờ giao hàng'])->with('ok', 'Đơn hàng đang được giao');
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