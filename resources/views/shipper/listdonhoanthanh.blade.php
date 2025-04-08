@extends('layout.shipper')
@section('content')
<div class="container">
    <div class="section-title">Quản Lý Đơn Hàng</div>

    <!-- Bảng Đơn Hàng -->
    <table class="order-table">
        <thead>
            <tr>
                {{-- <th><input type="checkbox" id="selectAll"> Chọn Tất Cả</th> --}}
                <th>Mã Đơn Hàng</th>
                <th>Khách Hàng</th>
                <th>Thời Gian Đặt Hàng</th>
                <th>Trạng Thái</th>
                <th>Chi Tiết</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    {{-- <td><input type="checkbox" class="order-select"></td> --}}
                    <td>{{$order->id}}</td>
                    <td>{{$order->name_order}}</td>
                    <td>{{$order->order_date}}</td>
                    <td>
                        @if($order->status == "Đã giao" || $order->status == "Hoàn thành" ||$order->status == "Vận chuyển")
                            <span class="order-status completed">{{$order->status}}</span></td>
                        @else
                            <span class="order-status pending">{{$order->status}}</span></td>
                        @endif
                    <td><a href="{{route('shipper.orders.show',$order->id)}}" class="btn">Xem Chi Tiết</a></td>
                </tr>

            @endforeach

        </tbody>

    </table>
   {{-- <div style="width:20px">{{$orders->links()}}</div>  --}}

    <!-- Phân Trang -->
    {{-- <div class="pagination">
        <button>Trang 1</button>
        <button>Trang 2</button>
        <button>Trang 3</button>
    </div>

    <!-- Nút Cập Nhật Trạng Thái -->
    <div class="checkbox-group">
        <label><input type="checkbox" id="selectAll"> Chọn Tất Cả Đơn Hàng</label>
        <button class="btn">Cập Nhật Trạng Thái</button>
    </div> --}}
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
    flex-direction: column;
    align-items: center;
    padding: 30px;
    width: 100%;
    max-width: 1200px; /* Max width for larger screens */
    margin: auto;
}

.section-title {
    text-align: center;
    color: #333;
    margin-bottom: 30px;
    font-size: 28px;
    font-weight: bold;
}

.order-card {
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin: 20px 0;
    padding: 20px;
    width: 100%;
    max-width: 800px;
}

.order-card h3 {
    font-size: 24px;
    margin-bottom: 15px;
    color: #333;
}

.order-card p {
    font-size: 16px;
    color: #555;
    margin-bottom: 10px;
}

.order-card .details {
    margin-top: 15px;
    padding: 15px;
    background-color: #ececec;
    border-radius: 5px;
    margin-bottom: 10px;
}

.order-card .details span {
    display: block;
    margin-bottom: 5px;
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

.checkbox-group {
    display: flex;
    flex-direction: column;
}

.checkbox-group label {
    margin: 5px 0;
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

.order-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.order-table th,
.order-table td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: center;
}

.order-table th {
    background-color: #f2f2f2;
    color: #333;
}

.order-table td {
    background-color: #fff;
}

.pagination {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.pagination button {
    padding: 10px 15px;
    margin: 0 5px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.pagination button:hover {
    background-color: #45a049;
}

/* Responsive Styles */
@media (max-width: 768px) {
    .container {
        padding: 20px;
    }

    .section-title {
        font-size: 24px;
    }

    .order-card {
        padding: 15px;
    }

    .order-table th, .order-table td {
        padding: 8px;
    }

    .btn {
        padding: 10px 15px;
        font-size: 14px;
    }

    .order-table {
        font-size: 14px;
    }

    .order-status {
        padding: 8px;
        font-size: 14px;
    }

    .pagination button {
        padding: 8px 12px;
        font-size: 14px;
    }
}

@media (max-width: 480px) {
    .navbar a {
        font-size: 16px;
        padding: 8px;
    }

    .section-title {
        font-size: 20px;
    }

    .order-card h3 {
        font-size: 20px;
    }

    .order-card p {
        font-size: 14px;
    }

    .order-table th, .order-table td {
        font-size: 12px;
        padding: 6px;
    }

    .order-status {
        font-size: 12px;
        padding: 6px;
    }

    .pagination button {
        padding: 6px 10px;
        font-size: 12px;
    }

    .container {
        width: 100%;
        margin: 0;
    }
}

</style>
