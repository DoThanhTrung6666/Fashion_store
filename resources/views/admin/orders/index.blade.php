@extends('layout.admin')

@section('content')

<style>
    body {
        background-color: #f8f9fa;
    }
    .table-wrapper {
        margin: 20px auto;
        padding: 20px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .table-title {
        margin-bottom: 20px;
        font-size: 24px;
        font-weight: bold;
    }
    .status-badge {
        font-size: 12px;
        padding: 5px 10px;
        border-radius: 20px;
    }
    .badge-pending { background-color: #ffc107; color: #212529; }
    .badge-confirmed { background-color: #17a2b8; color: white; }
    .badge-shipping { background-color: #6c757d; color: white; }
    .badge-delivered { background-color: #28a745; color: white; }
    .badge-cancelled { background-color: #dc3545; color: white; }
    .badge-vnpay { background-color: #dc3545; color: white; }
    .badge-ttknh { background-color: #28a745; color: white; }

    .order-tabs .nav-link {
    font-size: 16px;
    color: #6c757d;
    display: flex;
    align-items: center;
    gap: 8px; /* Khoảng cách giữa biểu tượng và chữ */
    padding: 10px 15px;
    transition: color 0.3s, background-color 0.3s;
    border-radius: 5px; /* Bo góc đẹp mắt */
}

.order-tabs .nav-link:hover {
    color: #fff;
    background-color: #00ff11; /* Màu nền khi hover */
}

.order-tabs .nav-link.active {
    color: #fff;
    background-color: #ff0000; /* Màu nền tab đang chọn */
    border-color: #007bff;
}

.order-tabs .nav-link i {
    font-size: 18px; /* Kích thước icon */
}
</style>


<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Danh sách đơn hàng
        </h1>
    </section>
    @if (session('ok'))
    <div class="alert alert-success" style="margin-left: 15px; margin-bottom:10px">
        {{ session('ok') }}
    </div>
@endif
    <section class="content">
        
        <div class="row container-fluid">

            
            
        </div>

        <div class="table-wrapper">
           <!-- Tab Navigation -->
           <ul class="nav nav-tabs order-tabs">
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'Chờ xác nhận' ? 'active' : '' }}" href="{{ route('admin.orders.index')}}?status=Chờ xác nhận"><i class="fas fa-clock"></i> Chờ xác nhận</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'Vận chuyển' ? 'active' : '' }}" href="{{ route('admin.orders.index')}}?status=Vận chuyển"><i class="fas fa-truck"></i> Vận chuyển</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'Chờ giao hàng' ? 'active' : '' }}" href="{{ route('admin.orders.index')}}?status=Chờ giao hàng"><i class="fas fa-box"></i> Chờ giao hàng</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'Hoàn thành' ? 'active' : '' }}" href="{{route('admin.orders.index')}}?status=Hoàn thành"><i class="fas fa-check-circle"></i> Hoàn thành</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'Đã huỷ' ? 'active' : '' }}" href="{{route('admin.orders.index')}}?status=Đã huỷ"><i class="fas fa-times-circle"></i> Đơn bị hủy</a>
            </li>
        </ul>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Khách hàng</th>
                        <th>Tổng giá</th>
                        <th>Trạng thái</th>
                        <th>Phương thức thanh toán</th>
                        <th>Ngày đặt hàng</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach( $orders as $order)
                                <tr>
                                    <td>#{{ $order->id }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td >{{ $order->total_amount }}</td>
                                    <td>
                                        @if ($order->status == 'Chờ xác nhận')
                                        <span class="status-badge badge-pending">Chờ xác nhận</span>
                                    @elseif ($order->status == 'Vận chuyển')
                                    <span class="status-badge badge-confirmed">Vận chuyển</span>
                                    @elseif ($order->status == 'Chờ giao hàng')
                                    <span class="status-badge badge-shipping">Chờ giao hàng</span>
                                    @elseif ($order->status == 'Hoàn thành')
                                    <span class="status-badge badge-delivered">Hoàn thành</span>
                                    @else
                                    <span class="status-badge badge-cancelled">Đã hủy</span>
                                    @endif

                                        </td>
                                    <td>
                                        @if ($order->payment == 1)
                                        <span class="status-badge badge-vnpay">VNPAY</span>
                                    @else
                                        <span class="status-badge badge-ttknh">Thanh toán khi nhận hàng</span>
                                    @endif
                                    </td>
                                    <td>{{ $order->order_date }}</td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order->id) }}"><button class="btn btn-info btn-sm">Xem chi tiết</button></a>
                                    </td>
                                </tr>
                            @endforeach
                    
                </tbody>
            </table>
        </div>

    </section>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">


@endsection