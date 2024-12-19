<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Mail\mailOrder;
use App\Mail\statuscancel;
use App\Models\Order;
use App\Models\Shipper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
    $user = User::where('id',$order->user_id)->first();
    // dd($user);
    // Lấy trạng thái từ request, mặc định là 'chờ xác nhận'
    $status = request('status', 'Chờ xác nhận');

    // Kiểm tra nếu đơn hàng chưa được giao
    if ($order->status != 'Hoàn thành') {
        $order->update(['status' => $status]);

        // Điều hướng tùy theo trạng thái mới
        if ($status === 'Hoàn thành') {
            return redirect()->route('admin.orders.index', ['status' => 'Hoàn thành'])->with('ok', 'Cập nhật trạng thái thành công');
        } elseif ($status === 'Đã huỷ') {
            Mail::to($user->email)->send(new statuscancel ($user,$order));
            return redirect()->route('admin.orders.index', ['status' => 'Đã huỷ'])->with('ok', 'Đơn hàng đã được hủy');
        } elseif ($status === 'Vận chuyển') {
            return redirect()->route('admin.orders.index', ['status' => 'Vận chuyển'])->with('ok', 'Đơn hàng đã vận chuyển');
        } elseif ($status === 'Chờ giao hàng') {
            return redirect()->route('admin.orders.index', ['status' => 'Chờ giao hàng'])->with('ok', 'Đơn hàng đang được giao');
        }elseif ($status === 'Đã xác nhận') {
            return redirect()->route('admin.orders.index', ['status' => 'Đã xác nhận'])->with('ok', 'Đơn hàng đã được xác nhận');
        }elseif ($status === 'Đã giao') {
            return redirect()->route('admin.orders.index', ['status' => 'Đã giao'])->with('ok', 'Đơn hàng đã được giao');
        }

    }

    // Nếu đơn hàng đã giao, không cho phép cập nhật
    return redirect()->route('admin.orders.index')->with('no', 'Không thể cập nhật đơn hàng đã giao');
}


    public function show($id)
{



    // Fetch the order by ID
    $order = Order::with('user', 'orderItems')->findOrFail($id); // Include relationships like 'user' and 'items' if available
    $shippers = Shipper::all();
    // Pass the order data to the view
    return view('admin.orders.show', compact('order','shippers'));
}

// gán cho shipper
public function assignShipper(Request $request , $id){
    $order = Order::findOrFail($id);
    $order->update([
        'shipper_id' => $request->shipper_id,
        'status' => 'Vận chuyển',
    ]);
    return redirect()->back()->with('success','Gán cho shipper thành công');
}
}
