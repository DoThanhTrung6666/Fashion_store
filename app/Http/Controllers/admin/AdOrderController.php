<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdOrderController extends Controller
{

    public function index(Request $request)
    {
        // Lấy các tham số từ request
        $status = $request->input('status', ''); // Trạng thái
        $search = $request->input('search', ''); // Từ khóa tìm kiếm
    
        // Lọc và phân trang đơn hàng
        $orders = Order::orderBy('id', 'DESC')
            ->when($status, function ($query) use ($status) {
                // Lọc theo trạng thái nếu có
                $query->where('status', $status);
            })
            ->where(function ($query) use ($search) {
                // Tìm theo ID hoặc tên đơn hàng
                $query->when(is_numeric($search), function ($query) use ($search) {
                    $query->orWhere('id', $search);
                })
                ->orWhere('name_order', 'LIKE', "%{$search}%");
            })
            ->paginate()
            ->appends(['status' => $status, 'search' => $search]); // Giữ các tham số tìm kiếm khi phân trang
    
        // Trả về view với dữ liệu đơn hàng
        return view('admin.orders.index', compact('orders', 'status', 'search'));
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