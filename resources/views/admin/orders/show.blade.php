@extends('layout.admin')

@section('content')

    <style>
        body {
            background-color: #f8f9fa;
        }

        .order-detail-wrapper {
            margin: 30px auto;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .order-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .order-info,
        .product-list {
            margin-bottom: 30px;
        }

        .product-item {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }

        .product-item:last-child {
            border-bottom: none;
        }

        .total-price {
            margin-top: 20px;
            font-size: 20px;
            font-weight: bold;
            color: #28a745;
            text-align: right;
        }

        .status-badge {
            font-size: 14px;
            padding: 5px 10px;
            border-radius: 20px;
        }

        .badge-pending {
            background-color: #ffc107;
            color: #212529;
        }

        .badge-confirmed {
            background-color: #17a2b8;
            color: white;
        }

        .badge-shipping {
            background-color: #6c757d;
            color: white;
        }

        .badge-delivered {
            background-color: #28a745;
            color: white;
        }

        .badge-cancelled {
            background-color: #dc3545;
            color: white;
        }

        .divider {
            border: none;
            border-top: 1px solid #ddd;
            /* Màu sắc đường gạch ngang */
            margin: 10px 0;
        }


        .order-title h1 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .order-info,
        .product-list {
            margin-bottom: 30px;
        }

        .product-item {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }

        .product-item:last-child {
            border-bottom: none;
        }

        .total-price {
            font-size: 20px;
            font-weight: bold;
            color: #28a745;
            text-align: right;
        }

        .status-badge {
            font-size: 14px;
            padding: 5px 10px;
            border-radius: 20px;
        }

        .badge-pending {
            background-color: #ffc107;
            color: #212529;
        }

        .badge-confirmed {
            background-color: #17a2b8;
            color: white;
        }

        .badge-shipping {
            background-color: #6c757d;
            color: white;
        }

        .badge-delivered {
            background-color: #28a745;
            color: white;
        }

        .badge-cancelled {
            background-color: #dc3545;
            color: white;
        }

        .divider {
            border: none;
            border-top: 1px solid #ddd;
            /* Màu sắc đường gạch ngang */
            margin: 10px 0;
        }

        .divider-row {
            height: 0;
        }

        .product-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background-color: #fafafa;
        }

        .product-table th,
        .product-table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .product-table th {
            background-color: #4CAF50;
            color: white;
        }

        .product-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .product-table img {
            max-width: 50px;
            height: auto;
        }

        .order-total {
            margin-top: 20px;
            font-size: 18px;
            text-align: right;
            font-weight: bold;
            color: #4CAF50;
        }

        .order-total p {
            margin-top: 10px;
        }

    </style>
    <div class="content-wrapper">

        <section class="content">
            <div class="row container-fluid">
                <div class="col-md-12">
                    <div class="">





                        <div class="container">
                            <div class="order-detail-wrapper">

                                <div class="order-title text-center">
                                    <h1>CHI TIẾT ĐƠN HÀNG</h1>
                                </div>

                                <!-- Thông tin đơn hàng -->
                                <div class="order-info">
                                    <p><strong>Mã đơn hàng:</strong> #{{ $order->id }}</p>
                                    <p><strong>Ngày đặt:</strong> {{ $order->order_date }}</p>
                                    <p><strong>Trạng thái:</strong>
                                        @if ($order->status == 'Chờ xác nhận')
                                        <span>
                                            @if(session('error'))
                                                <p style="color: red">{{session('error')}}</p>
                                            @endif
                                        </span>
                                            <span class="status-badge badge-pending">Chờ xác nhận</span>

                                        @elseif ($order->status == 'Đã xác nhận')
                                            <span class="status-badge" style="background-color: #17a2b8; color: #fff;">Đã xác nhận</span>
                                        @elseif ($order->status == 'Vận chuyển')
                                            <span class="status-badge" style="background-color: #007bff; color: #fff;">Vận chuyển</span>
                                        @elseif ($order->status == 'Đang vận chuyển')
                                            <span class="status-badge" style="background-color: #6610f2; color: #fff;">Đang vận chuyển</span>
                                        @elseif ($order->status == 'Đã giao')
                                            <span class="status-badge" style="background-color: #20c997; color: #fff;">Đã giao</span>
                                        @elseif ($order->status == 'Hoàn thành')
                                            <span class="status-badge" style="background-color: #28a745; color: #fff;">Hoàn thành</span>
                                        @else
                                            <span class="status-badge" style="background-color: #dc3545; color: #fff;">Đã hủy</span>
                                        @endif
                                    </p>

                                    <p><strong>Khách hàng:</strong> {{ $order->user->name }}</p>
                                    <p><strong>Số điện thoại:</strong> {{ $order->phone_order }}</p>
                                    <p><strong>Địa chỉ:</strong> {{ $order->address_order }}</p>
                                    <p><strong>Lí do huỷ:</strong> {{ $order->cancel_reason }}</p>
                                </div>

                                <!-- Danh sách sản phẩm -->
                                <div class="product-list">
                                    <h5><strong>Sản phẩm:</strong></h5>


                                    <table class="product-table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Tên sản phẩm</th>
                                                <th>Ảnh</th>
                                                <th>Size</th>
                                                <th>Màu</th>
                                                <th>Giá tiền</th>
                                                <th>Số lượng</th>

                                                <th>Tổng tiền</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order->orderItems as $item)
                                                <tr>
                                                    <td>#{{ $item->productvariant->product->id }}</td>
                                                    <td>{{ $item->productvariant->product->name }}</td>
                                                    <td><img src="{{ asset('storage/' . $item->productvariant->image_variant) }}"></td>
                                                    <td>{{ $item->productvariant->size->name }}</td>
                                                    <td>{{ $item->productvariant->color->name }}</td>
                                                    <td>{{ number_format($item->price) }}</td>
                                                    <td>{{ $item->quantity }}</td>

                                                    <td>{{ number_format($item->price * $item->quantity) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <div class="total-price">

                                        <p>Tổng cộng: {{ number_format($order->total_amount ) }} VND</p>
                                        </div>


                                <!-- Hành động -->


                                @if (
                                    $order->status != 'Đã huỷ' &&
                                        $order->status != 'Đang vận chuyển' &&
                                        $order->status != 'Hoàn thành' &&
                                        $order->status != 'Vận chuyển' &&
                                        $order->status != 'Đã xác nhận' &&
                                        $order->status != 'Đã giao')
                                    <div class="mt-4 text-center">
                                        <a href="{{ route('admin.order.update', $order->id) }}?status=Đã huỷ"
                                            onclick="return confirm('xác nhận')"> <button
                                                class="btn btn-danger btn-cancel">Hủy đơn hàng</button></a>
                                        <a href="{{ route('admin.order.update', $order->id) }}?status=Đã xác nhận"
                                            onclick="return confirm('xác nhận')"><button
                                                class="btn btn-success btn-confirm">Xác nhận đơn hàng</button></a>
                                    </div>
                                @elseif($order->status == 'Đang vận chuyển')
                                    <div class="mt-4 text-center" style="margin-left: 15px; margin-bottom:10px">
                                        {{-- <a href="{{ route('admin.order.update', $order->id) }}?status=Hoàn thành"
                                            onclick="return confirm('xác nhận')"><button
                                                class="btn btn-success btn-confirm">Giao hàng</button></a> --}}
                                        <a href="{{ route('admin.orders.index') }}?status=Đang vận chuyển"><button
                                                class="btn btn-success btn-confirm">Quay lại</button></a>
                                    </div>
                                @elseif($order->status == 'Hoàn thành')
                                    <div class="mt-4 text-center" style="margin-left: 15px; margin-bottom:10px">
                                        <a href="{{ route('admin.orders.index') }}?status=Hoàn thành"><button
                                                class="btn btn-success btn-confirm">Quay lại</button></a>
                                    </div>
                                @elseif($order->status == 'Vận chuyển')
                                    <div class="mt-4 text-center" style="margin-left: 15px; margin-bottom:10px">
                                        <a href="{{ route('admin.orders.index') }}?status=Vận chuyển"><button
                                                class="btn btn-success btn-confirm">Quay lại</button></a>
                                    </div>
                                @elseif($order->status == 'Đã huỷ')
                                    <div class="mt-4 text-center" style="margin-left: 15px; margin-bottom:10px">
                                        <a href="{{ route('admin.orders.index') }}?status=Đã huỷ"><button
                                                class="btn btn-primary btn-confirm">Quay về trang hủy đơn</button></a>
                                    </div>
                                @elseif($order->status == 'Đã giao')
                                    <div class="mt-4 text-center" style="margin-left: 15px; margin-bottom:10px">
                                        <a href="{{ route('admin.order.update', $order->id) }}?status=Hoàn thành"
                                            onclick="return confirm('xác nhận')"><button
                                                class="btn btn-success btn-confirm">Hoàn thành</button></a>
                                    </div>
                                @elseif($order->status == 'Đã xác nhận')
                                    <div class="mt-4 text-center" style="margin-left: 15px; margin-bottom:10px">
                                        <form action="{{ route('admin.orders.assign', $order->id) }}" method="POST">
                                            @csrf
                                            <label for="shipper_id">Chọn shipper:</label>
                                            <select name="shipper_id" id="shipper_id" class="form-control">
                                                @foreach ($shippers as $shipper)
                                                    <option value="{{ $shipper->id }}">{{ $shipper->name }}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="btn btn-success mt-3" style="margin-top:15px;">Gán shipper</button>
                                        </form>
                                        {{-- <a href="{{ route('admin.orders.index') }}?status=Vận chuyển"
                                        onclick="return confirm('xác nhận')"><button
                                            class="btn btn-primary btn-confirm">Gán shipper</button></a> --}}
                                    </div>
                                @endif

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
