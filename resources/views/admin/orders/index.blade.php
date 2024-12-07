@extends('layout.admin')

@section('content')


<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Danh sách đơn hàng
        </h1>
    </section>
    <section class="content">
        <div style="margin-left: 15px; margin-bottom:10px">
                    <a href="{{ route('admin.orders.index')}}?status=Chờ xác nhận" class="btn btn-primary">Chờ xác nhận</a>
                    <a href="{{ route('admin.orders.index')}}?status=Vận chuyển" class="btn btn-warning">Vận chuyển</a>
                    <a href="{{ route('admin.orders.index')}}?status=Chờ giao hàng" class="btn btn-danger">Chờ giao hàng</a>
                    <a href="{{route('admin.orders.index')}}?status=Hoàn thành" class="btn btn-success">Hoàn thành</a>
                    <a href="{{route('admin.orders.index')}}?status=Đã huỷ" class="btn btn-warning">Đơn bị hủy</a>
        </div>
        <div class="row container-fluid">

            <div class="col-md-12">
                <div class="box box-primary">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Payment</th>
                                <th>Order_date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->total_amount }}</td>
                                    <td>{{ $order->status }}</td>
                                    <td>{{ $order->payment }}</td>
                                    <td>{{ $order->order_date }}</td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-info">View Details</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>



                </div>
            </div>
        </div>
    </section>
</div>


<script>
    function disableOtherOptions(selectedRadio) {
        // Get all radio buttons in the current form
        const form = selectedRadio.closest('form');
        const radios = form.querySelectorAll('input[type="radio"]');

        // Disable all other radio buttons
        radios.forEach(radio => {
            if (radio !== selectedRadio) {
                radio.disabled = true;
            }
        });
    }
</script>
@endsection