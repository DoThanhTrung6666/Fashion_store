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
    .order-info, .product-list {
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
    .badge-pending { background-color: #ffc107; color: #212529; }
    .badge-confirmed { background-color: #17a2b8; color: white; }
    .badge-shipping { background-color: #6c757d; color: white; }
    .badge-delivered { background-color: #28a745; color: white; }
    .badge-cancelled { background-color: #dc3545; color: white; }
    
    .divider {
    border: none;
    border-top: 1px solid #ddd; /* Màu sắc đường gạch ngang */
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

.product-table th, .product-table td {
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
                                <div class="order-title">Chi tiết đơn hàng</div>
                    
                                <!-- Thông tin đơn hàng -->
                                <div class="order-info">
                                    <p><strong>Mã đơn hàng:</strong>  #{{ $order->id }}</p>
                                    <p><strong>Ngày đặt:</strong> {{ $order->order_date }}</p>
                                    <p><strong>Trạng thái:</strong> 
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
                                    </p>
                                    <p><strong>Khách hàng:</strong> {{ $order->user->name }}</p>
                                    <p><strong>Số điện thoại:</strong> {{ $order->phone_order }}</p>
                                    <p><strong>Địa chỉ:</strong> {{ $order->address_order }}</p>
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
                                            <th>Giá tiền</th>
                                            <th>Số lượng</th>
                                            <th>Tổng tiền</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order->orderItems as $item)
                                          <tr>
                                            <td>#{{$item->productvariant->product->id}}</td>
                                            <td>{{ $item->productvariant->product->name }}</td>
                                            <td><img src="{{ asset('storage/' . $item->productvariant->product->image) }}"></td>
                                            <td>{{number_format($item->price)  }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{number_format($item->price * $item->quantity)}}</td>
                                          </tr>
                                          @endforeach
                                          
                                        </tbody>
                                      </table>

                                    
                                </div>
                    
                                <!-- Tổng giá -->
                                <div class="total-price">Tổng cộng: {{number_format($order->total_amount)  }} VND</div>
                    
                                <!-- Hành động -->
                                

                                @if (
                           
                                $order->status != 'Chờ giao hàng' &&
                                $order->status != 'Hoàn thành' &&
                                $order->status != 'Vận chuyển')
                            <div class="mt-4 text-center">
                                <a href="{{ route('admin.order.update', $order->id) }}?status=Đã huỷ" onclick="return confirm('xác nhận')"> <button class="btn btn-danger btn-cancel">Hủy đơn hàng</button></a>
                                 <a href="{{ route('admin.order.update', $order->id) }}?status=Vận chuyển" onclick="return confirm('xác nhận')"><button class="btn btn-success btn-confirm">Xác nhận đơn hàng</button></a>
                             </div>
                        @elseif($order->status == 'Chờ giao hàng')
                            <div class="mt-4 text-center" style="margin-left: 15px; margin-bottom:10px">
                                <a href="{{ route('admin.order.update', $order->id) }}?status=Hoàn thành" onclick="return confirm('xác nhận')"><button class="btn btn-success btn-confirm">Giao hàng</button></a>
                                </div>
                        @elseif($order->status == 'Vận chuyển')
                            <div class="mt-4 text-center" style="margin-left: 15px; margin-bottom:10px">
                                <a href="{{ route('admin.order.update', $order->id) }}?status=Chờ giao hàng" onclick="return confirm('xác nhận')"><button class="btn btn-success btn-confirm">Chờ giao hàng</button></a>
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
