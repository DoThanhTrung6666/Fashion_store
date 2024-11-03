<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // public function index()
    // {
    //     $orders = Order::all();
    //     return view('admin.orders.index', compact('orders'));
    // }

    // public function create()
    // {
    //     return view('admin.orders.create');
    // }

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'customer_name' => 'required|string',
    //         'product_name' => 'required|string',
    //         'quantity' => 'required|integer',
    //         'price' => 'required|numeric',
    //     ]);

    //     Order::create($validated);

    //     return redirect()->route('orders.index')->with('success', 'Đơn hàng đã được tạo thành công.');
    // }

    // public function edit(Order $order)
    // {
    //     return view('admin.orders.update', compact('order'));
    // }

    // public function update(Request $request, Order $order)
    // {
    //     $validated = $request->validate([
    //         'customer_name' => 'required|string',
    //         'product_name' => 'required|string',
    //         'quantity' => 'required|integer',
    //         'price' => 'required|numeric',
    //     ]);

    //     $order->update($validated);

    //     return redirect()->route('orders.index')->with('success', 'Đơn hàng đã được cập nhật.');
    // }

    // public function destroy(Order $order)
    // {
    //     $order->delete();
    //     return redirect()->route('orders.index')->with('success', 'Đơn hàng đã được xóa.');
    // }

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
