@extends('layout.shipper')
@section('content')
<div class="container">
    <!-- Đơn Hàng -->
    <div class="section-title">Đơn Hàng Của Bạn</div>

    <div class="order-card">


         <h3>Đơn Hàng #{{$detailOrder->id}}</h3>
        <p><strong>Khách Hàng:</strong> {{$detailOrder->name_order}}</p>
        <p><strong>Địa Chỉ Giao:</strong> {{$detailOrder->address_order}}</p>
        <p><strong>Số điện thoại:</strong> {{$detailOrder->phone_order}}</p>
        <div class="details">
            <span><strong>Thời Gian Đặt Hàng:</strong> {{$detailOrder->order_date}}</span>
            {{-- @foreach ($detailOrder->orderItems as $orderItem) --}}
                <span>
                    <strong>
                        Sản Phẩm:</strong> {{$detailOrder->orderItems->first()->productVariant->product->name}},
                        Số lượng: {{$detailOrder->orderItems->first()->quantity}}
                    </span>
            {{-- @endforeach --}}
            <span>
                <strong>Phương Thức Thanh Toán : </strong>
                @if($detailOrder->payment==1)
                    Thanh toán khi nhận hàng
                @else
                    Thanh toán online
                @endif
            </span>
        </div>
        <div class="order-status pending">
            <p>Trạng Thái: {{$detailOrder->status}}</p>
        </div>
        @if($detailOrder->status == 'Vận chuyển'||$detailOrder->status == 'Đã xác nhận')
        <form action="{{route('shipper.orders.update',$detailOrder->id)}}" method="POST">
            @csrf
            <button type="submit" class="btn">Vận chuyển</button>
        </form>
        @else
        <form action="{{route('shipper.orders.update2',$detailOrder->id)}}" method="POST">
            @csrf
            <button type="submit" class="btn">Giao hàng</button>
        </form>
        @endif
        {{-- <a href="{{ route('shipper.orders.update', $detailOrder->id) }}?status=Chờ giao hàng"
            onclick="return confirm('xác nhận')"><button
                class="btn btn-success btn-confirm">Vận chuyển</button></a> --}}
        {{-- <a href="{{route('shipper.orders.update',$detailOrder->id)}}" class="btn">Cập Nhật Trạng Thái</a> --}}
        <a href="{{route('shipper.orders.index')}}" class="btn">Quay lại</a>
    </div>




    {{-- <!-- Lịch Sử Giao Hàng -->
    <div class="section-title">Lịch Sử Giao Hàng</div>

    <div class="history-card">
        <h3>Đơn Hàng #12344</h3>
        <p><strong>Khách Hàng:</strong> Trần Thị B</p>
        <p><strong>Địa Chỉ Giao:</strong> 456 Đường XYZ, Quận ABC, TP.HCM</p>
        <div class="details">
            <span><strong>Thời Gian Giao Hàng:</strong> 19/12/2024, 04:30 PM</span>
            <span><strong>Sản Phẩm:</strong> Giày thể thao, Số lượng: 1</span>
            <span><strong>Phương Thức Thanh Toán:</strong> Chuyển khoản</span>
        </div>
        <div class="order-status completed">
            <p>Trạng Thái: Đã Hoàn Thành</p>
        </div>
    </div>

    <!-- Bảng Lịch Sử Giao Hàng -->
    <table class="history-table">
        <thead>
            <tr>
                <th>Mã Đơn Hàng</th>
                <th>Khách Hàng</th>
                <th>Thời Gian Giao Hàng</th>
                <th>Trạng Thái</th>
                <th>Chi Tiết</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>#12343</td>
                <td>Lê Minh C</td>
                <td>18/12/2024, 10:00 AM</td>
                <td><span class="order-status completed">Đã Hoàn Thành</span></td>
                <td><a href="#" class="btn">Xem Chi Tiết</a></td>
            </tr>
            <tr>
                <td>#12342</td>
                <td>Nguyễn Thị D</td>
                <td>17/12/2024, 02:00 PM</td>
                <td><span class="order-status canceled">Đã Hủy</span></td>
                <td><a href="#" class="btn">Xem Chi Tiết</a></td>
            </tr>
        </tbody>
    </table> --}}

</div>
@endsection
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }

    .navbar {
        background-color: #333;
        color: white;
        padding: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .navbar a {
        color: white;
        text-decoration: none;
        font-size: 18px;
        padding: 10px;
        margin: 0 10px;
    }

    .navbar a:hover {
        background-color: #575757;
        border-radius: 5px;
    }

    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        padding: 30px;
    }

    .section-title {
        text-align: center;
        color: #333;
        margin-bottom: 30px;
        font-size: 28px;
        font-weight: bold;
    }

    .order-card,
    .history-card {
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin: 20px 0;
        padding: 20px;
        width: 80%;
        max-width: 800px;
    }

    .order-card h3,
    .history-card h3 {
        font-size: 24px;
        margin-bottom: 15px;
        color: #333;
    }

    .order-card p,
    .history-card p {
        font-size: 16px;
        color: #555;
        margin-bottom: 10px;
    }

    .order-card .details,
    .history-card .details {
        margin-top: 15px;
        padding: 15px;
        background-color: #ececec;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    .order-card .details span,
    .history-card .details span {
        display: block;
        margin-bottom: 5px;
    }

    .btn {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
    }

    .btn:hover {
        background-color: #45a049;
    }

    .footer {
        background-color: #333;
        color: white;
        padding: 10px 0;
        text-align: center;
        position: fixed;
        bottom: 0;
        width: 100%;
    }

    .footer p {
        margin: 0;
    }

    .order-status {
        padding: 10px;
        background-color: #ececec;
        margin: 10px 0;
        border-radius: 5px;
        text-align: center;
    }

    .order-status.completed {
        background-color: #d4edda;
        color: #155724;
    }

    .order-status.pending {
        background-color: #fff3cd;
        color: #856404;
    }

    .order-status.canceled {
        background-color: #f8d7da;
        color: #721c24;
    }

    .history-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .history-table th,
    .history-table td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: center;
    }

    .history-table th {
        background-color: #f2f2f2;
        color: #333;
    }

    .history-table td {
        background-color: #fff;
    }
</style>
