@extends('layout.admin')

@section('content')


<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Danh sách đơn hàng
        </h1>
    </section>
    <section class="content">
        <div class="row container-fluid">
            <div class="col-md-12">
                <div class="box box-primary">


                    <h3>Order Details (Order ID: {{ $order->id }})</h3>
                    <div class="mb-4">
                        <h5>Customer Details</h5>
                        <p><strong>Name:</strong> {{ $order->user->name }}</p>
                        <p><strong>Email:</strong> {{ $order->user->email }}</p>
                        <p><strong>Order Date:</strong> {{ $order->order_date }}</p>
                        <p><strong>Status:</strong> {{ $order->status }}</p>
                        <p><strong>Total Amount:</strong> {{ $order->total_amount }}</p>
                    </div>
                    <div>
                        <h5>Order Items</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th>Quantity</th>

                                    <th>Ảnh</th>
                                    <th>Price</th>

                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                    <tr>
                                        <td>{{ $item->productvariant->product->name }}</td>
                                        <td>{{ $item->quantity }}</td>

                                        <th><img src="{{Storage::url($item->productvariant->product->image)}}" alt="" width="100"></th>
                                        <td>{{ $item->price }}</td>

                                        <td>{{ $item->quantity * $item->price }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Back to Orders</a>
                </div>
            </div>
        </div>
    </section>
</div>


@endsection

