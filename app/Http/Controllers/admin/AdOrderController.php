<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdOrderController extends Controller
{

    public function pendingOrders()
{
    // Get orders that are pending confirmation
    $pendingOrders = Order::where('status', 'Chờ xác nhận')->get();

    // Pass pending orders to the view
    return view('admin.orders.pending', compact('pendingOrders'));
}
public function confirmedOrders()
{
    // Get orders that are confirmed
    $confirmedOrders = Order::where('status', 'Đã xác nhận')->get();

    // Pass confirmed orders to the view
    return view('admin.orders.confirmed', compact('confirmedOrders'));
}
public function shippingOrders()
{
    // Get orders that are waiting for shipping
    $shippingOrders = Order::where('status', 'Chờ giao hàng')->get();

    // Pass the shipping orders to the view
    return view('admin.orders.shipping', compact('shippingOrders'));
}
public function deliveredOrders()
{
    // Get orders that are delivered
    $deliveredOrders = Order::where('status', 'Đã giao hàng')->get();

    // Pass the delivered orders to the view
    return view('admin.orders.delivered', compact('deliveredOrders'));
}
public function canceledOrders()
{
    // Get orders that are canceled
    $canceledOrders = Order::where('status', 'Đã hủy')->get();

    // Pass the canceled orders to the view
    return view('admin.orders.canceled', compact('canceledOrders'));
}

public function index() {
    $status = request('status', 'Đã xác nhận');
    $orders = Order::orderBy('id','DESC')->where('status', $status)->paginate();
    

    return view('admin.orders.index', compact('orders'));
}


    

   

    public function update(Order $order) {
        $status = request('status', 'chờ xác nhận');
        if ($order->status != 'đã giao hàng') {
            $order->update(['status' => $status]);
            return redirect()->route('admin.orders.index')->with('ok', 'Cập nhật trạng thái thanh công');
        }
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
