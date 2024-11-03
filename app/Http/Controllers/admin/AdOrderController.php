<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdOrderController extends Controller
{
    public function index()
    {
        // Fetch orders by status
        $pendingOrders = Order::where('status', 'Chờ xác nhận')->get();
        $confirmedOrders = Order::where('status', 'Đã xác nhận')->get();
        $shippingOrders = Order::where('status', 'Chờ giao hàng')->get();
        $deliveredOrders = Order::where('status', 'Đã giao hàng')->get();

        return view('admin.orders.index', compact('pendingOrders', 'confirmedOrders', 'shippingOrders', 'deliveredOrders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Order status updated successfully!');
    }
}
