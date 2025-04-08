@extends('layout.shipper')
@section('content')
<div class="container">
    <h2 class="section-title">Chào Mừng Bạn Đến Với Giao Diện Shipper</h2>

    <div class="card">
        <i class="fas fa-truck"></i>
        <h3>Quản Lý Đơn Hàng</h3>
        <p>Xem tất cả đơn hàng của bạn và tình trạng giao hàng.</p>
        <a href="{{route('shipper.orders.index')}}" class="btn">Xem Đơn Hàng</a>
    </div>

    <div class="card">
        <i class="fas fa-calendar-check"></i>
        <h3>Lịch Sử Giao Hàng</h3>
        <p>Xem lại tất cả lịch sử giao hàng của bạn, bao gồm thời gian và trạng thái hoàn thành.</p>
        <a href="{{route('shipper.listdonhoanthanh')}}" class="btn">Xem Lịch Sử</a>
    </div>

    {{-- <div class="icon-container">
        <div class="icon-box">
            <i class="fas fa-map-marked-alt"></i>
            <p>Bản Đồ</p>
        </div>
        <div class="icon-box">
            <i class="fas fa-clock"></i>
            <p>Thời Gian</p>
        </div>
        <div class="icon-box">
            <i class="fas fa-comments"></i>
            <p>Liên Hệ</p>
        </div>
    </div> --}}

    <div class="section-title">Thông Tin Thống Kê</div>
    <div style="display:flex">
        <div class="stats-card">
            <h4>Số Đơn Đang Xử Lý</h4>
            <p>{{$totalOrders}}</p>
        </div>
        <div class="stats-card">
            <h4>Số Đơn Hoàn Thành</h4>
            <p>{{$totalOrdersHoanthanh}}</p>
        </div>
        <div class="stats-card">
            <h4>Tổng Thu Nhập</h4>
            <p>{{number_format($totalMoney)}} VND</p>
        </div>
    </div>

</div>
@endsection
