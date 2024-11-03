@extends('layout.admin')

@section('content')


<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Quan ly don hang
        </h1>
    </section>
    <section class="content">
        <div class="row container-fluid">
            <div class="col-md-12">
                <div class="box box-primary">

                    <h3>Orders Pending Confirmation</h3>

                    <table>
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $pendingOrders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->total_amount }}</td>
                                    <td>{{ $order->status }}</td>
                                    <td>
                                        <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
                                            @csrf
                                            <div>
                                                <label>
                                                    <input type="radio" name="status" value="Chờ xác nhận" onclick="disableOtherOptions(this)" {{ $order->status === 'Chờ xác nhận' ? 'checked disabled' : '' }}>
                                                    Chờ xác nhận
                                                </label>
                                                <label>
                                                    <input type="radio" name="status" value="Đã xác nhận" onclick="disableOtherOptions(this)" {{ $order->status === 'Đã xác nhận' ? 'checked disabled' : '' }}>
                                                    Đã xác nhận
                                                </label>
                                                <label>
                                                    <input type="radio" name="status" value="Chờ giao hàng" onclick="disableOtherOptions(this)" {{ $order->status === 'Chờ giao hàng' ? 'checked disabled' : '' }}>
                                                    Chờ giao hàng
                                                </label>
                                                <label>
                                                    <input type="radio" name="status" value="Đã giao hàng" onclick="disableOtherOptions(this)" {{ $order->status === 'Đã giao hàng' ? 'checked disabled' : '' }}>
                                                    Đã giao hàng
                                                </label>
                                                <label>
                                                    <input type="radio" name="status" value="Hủy đơn hàng" onclick="disableOtherOptions(this)" {{ $order->status === 'Hủy đơn hàng' ? 'checked disabled' : '' }}>
                                                    Hủy đơn hàng
                                                </label>
                                            </div>
                                            <button type="submit">Update Status</button>
                                        </form>
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