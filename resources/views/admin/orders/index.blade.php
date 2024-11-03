@extends('layout.admin')

@section('content')


<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Quan ly don hang
        </h1>
    </section>
    <section class="content">
        <div class="row container-fluid">
            <div class="col-md-12">
                <div class="box box-primary">

                    <h3>Orders Pending Confirmation</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingOrders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->total_amount }}</td>
                                    <td>{{ $order->status }}</td>
                                    <td>
                                        <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="status" value="Đã xác nhận">
                                            <button type="submit">Confirm</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                
                    <h3>Confirmed Orders</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($confirmedOrders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->total_amount }}</td>
                                    <td>{{ $order->status }}</td>
                                    <td>
                                        <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="status" value="Chờ giao hàng">
                                            <button type="submit">Ready for Shipping</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                
                    <h3>Orders Ready for Shipping</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($shippingOrders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->total_amount }}</td>
                                    <td>{{ $order->status }}</td>
                                    <td>
                                        <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="status" value="Đã giao hàng">
                                            <button type="submit">Mark as Delivered</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                
                    <h3>Delivered Orders</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($deliveredOrders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->total_amount }}</td>
                                    <td>{{ $order->status }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection