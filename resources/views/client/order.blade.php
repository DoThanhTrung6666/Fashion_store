@extends('layout.client')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Lịch sử đơn hàng của bạn</h2>

    @foreach ($orders as $order)
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-white text-dark d-flex justify-content-between">
            <span>Đơn hàng #{{ $order->id }}</span>
            <span>{{ date('d/m/Y', strtotime($order->order_date)) }}</span>
        </div>

        <div class="card-body">
            <p><strong>Tổng tiền:</strong> {{ number_format($order->total_amount, 0, ',', '.') }} VND</p>
            <p><strong>Trạng thái:</strong> <span class="badge badge-info">{{ $order->status }}</span></p>

            <h5 class="mt-3">Chi tiết sản phẩm:</h5>
            <ul class="list-group">
                @foreach ($order->orderItems as $item)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>{{ $item->product_name }} ({{ $item->quantity }}x)</span>
                    <span>{{ number_format($item->price * $item->quantity, 0, ',', '.') }} VND</span>
                </li>
                @endforeach
            </ul>
        </div>

        <div class="card-footer text-right">
            <a href="#" class="btn btn-sm btn-outline-primary">Xem chi tiết</a>
        </div>
    </div>
    @endforeach

    @if($orders->isEmpty())
    <div class="alert alert-info text-center">
        Bạn chưa có đơn hàng nào.
    </div>
    @endif
</div>
@endsection