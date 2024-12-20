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
            ->paginate(10)
            ->appends(['status' => $status, 'search' => $search]); // Giữ các tham số tìm kiếm khi phân trang

        // Trả về view với dữ liệu đơn hàng
        return view('admin.orders.index', compact('orders', 'status', 'search'));
    }









public function update(Order $order)
{
    // dd($order);
    $user = User::where('id', $order->user_id)->first();
    $status = request('status', 'Chờ xác nhận');


    // $orders = Order::where('user_id',$user->id)->first();
    // dd($orders);
    if($order->status=='Đã huỷ'){
        return redirect()->back()->with('error','Không thể xác nhận đơn hàng đã huỷ');
    }

    if ($order->status != 'Hoàn thành') {
        // If order is being cancelled, restore product quantities
        if ($status === 'Đã huỷ') {
            foreach ($order->orderItems as $orderItem) {
                $productVariant = $orderItem->productVariant;
                $productVariant->stock_quantity += $orderItem->quantity;
                $productVariant->save();
            }
            Mail::to($user->email)->send(new statuscancel($user, $order));
            $order->update(['status' => $status]);
            return redirect()->route('admin.orders.index', ['status' => 'Đã huỷ'])->with('ok', 'Đơn hàng đã được hủy và số lượng sản phẩm đã được hoàn lại');
        }

        $order->update(['status' => $status]);

        // Other status redirects remain the same
        if ($status === 'Hoàn thành') {
            return redirect()->route('admin.orders.index', ['status' => 'Hoàn thành'])->with('ok', 'Cập nhật trạng thái thành công');
        } elseif ($status === 'Vận chuyển') {
            return redirect()->route('admin.orders.index', ['status' => 'Vận chuyển'])->with('ok', 'Đơn hàng đã vận chuyển');
        } elseif ($status === 'Chờ giao hàng') {
            return redirect()->route('admin.orders.index', ['status' => 'Chờ giao hàng'])->with('ok', 'Đơn hàng đang được giao');
        } elseif ($status === 'Đã xác nhận') {
            return redirect()->route('admin.orders.index', ['status' => 'Đã xác nhận'])->with('ok', 'Đơn hàng đã được xác nhận');
        } elseif ($status === 'Đã giao') {
            return redirect()->route('admin.orders.index', ['status' => 'Đã giao'])->with('ok', 'Đơn hàng đã được giao');
        }
    }

    return redirect()->route('admin.orders.index')->with('no', 'Không thể cập nhật đơn hàng đã giao');
}
public function show($id)
{
    $order = Order::with([
        'user',
        'orderItems.productvariant.product',
        'orderItems.productvariant.size',
        'orderItems.productvariant.color',

    ])->findOrFail($id);

    $shippers = Shipper::all();

    return view('admin.orders.show', compact('order', 'shippers'));

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
