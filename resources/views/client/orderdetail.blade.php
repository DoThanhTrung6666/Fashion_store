@extends('layout.client')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Chi tiết Đơn hàng #{{$order->id}}</h2>

    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-white text-dark d-flex justify-content-between">
            <span>Ngày đặt hàng: {{ date('d/m/Y', strtotime($order->order_date)) }}</span>
            <span>Trạng thái: <span class="badge badge-info">{{ $order->status }}</span></span>
        </div>

        <div class="card-body">
            <p><strong>Tổng tiền:</strong> {{ number_format($order->total_amount, 0, ',', '.') }} VND</p>

            <h5 class="mt-3">Chi tiết sản phẩm:</h5>
            <ul class="list-group">
                @foreach ($order->orderItems as $item)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <img src="{{Storage::url($item->productVariant->product->image)}}" alt="{{ $item->productVariant->product->name }}" style="width: 50px; height: auto;">
                        <span>{{ $item->productVariant->product->name }} ({{ $item->quantity }}x)</span>
                        <br>
                        <small>Color: {{ $item->productVariant->color->name }}, Size: {{ $item->productVariant->size->name }}</small>
                    </div>
                    <span>{{ number_format($item->price * $item->quantity, 0, ',', '.') }} VND</span>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="text-center mt-4">
        <a href="{{ route('orders.loadUser') }}" class="btn btn-secondary">Quay lại lịch sử đơn hàng</a>
    </div>
</div>
@endsection
