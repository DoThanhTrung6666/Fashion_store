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
            <a href="{{ route('orders.show',$order->id)}}" class="btn btn-sm btn-outline-primary">Xem chi tiết</a>
            {{-- <a href="">{{$order->productVariant->id}}</a> --}}

        @if($order->status != 'Hủy đơn hàng' && $order->status != 'Chờ giao hàng' && $order->status != 'Đã giao hàng' && $order->status != 'Đã xác nhận')
            <form action="{{ route('orders.cancel', $order->id) }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?')">Hủy đơn hàng</button>
            </form>

            @elseif($order->status == 'Đã xác nhận')
            <span class="badge badge-secondary">Đơn hàng đã xác nhận</span>

            @elseif($order->status == 'Chờ giao hàng')
            <span class="badge badge-secondary">Đơn hàng chuẩn bị được giao</span>

            @elseif($order->status == 'Chờ giao hàng')
            <span class="badge badge-secondary">Đơn hàng chuẩn bị được giao</span>

            @elseif($order->status == 'Hủy đơn hàng')
            <form action="" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc chắn muốn mua lại đơn hàng này không?')">Mua lại</button>
            </form>
        @endif
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
