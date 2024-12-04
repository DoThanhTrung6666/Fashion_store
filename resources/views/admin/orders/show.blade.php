@extends('layout.admin')

@section('content')



<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Danh sách đơn hàng
        </h1>
    </section>
    @if ($order->status != 'đã giao hàng')
    @if ($order->status != 'hủy đơn hàng')
    <div class="text center">
        <a href="{{ route('admin.order.update', $order->id) }}?status=đã giao hàng" class="btn btn-danger" onclick="return confirm('Bạn có chắc hành động này là gì?')">Đã giao hàng</a>
    <a href="{{ route('admin.order.update', $order->id) }}?status=hủy đơn hàng" class="btn btn-warning" onclick="return confirm('Bạn có chắc hành động này là gì?')">Hủy</a>
    
    </div>
    @else
    <a href="{{ route('admin.order.update', $order->id) }}?status=chờ xác nhận" class="btn btn-warning" onclick="return confirm('Bạn có chắc hành động này là gì?')">Khoi phục</a>
    @endif
@endif
    <section class="content">
        <div class="row container-fluid">
            <div class="col-md-12">
                <div class="box box-primary">


                    
                    </div>

                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Back to Orders</a>
                </div>
            </div>
        </div>
    </section>
</div>


@endsection

