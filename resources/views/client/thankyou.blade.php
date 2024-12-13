@extends('layout.client')
@section('content')

<section class="">
    <div class="container">

        <div class="container text-center mt-0">
            <h1>Cảm Ơn Quý Khách!</h1>
            <p>Đơn hàng của bạn đã được đặt thành công.</p>
            <p>Chúng tôi sẽ gửi thông tin xác nhận đến email của bạn trong thời gian sớm nhất.</p>
            <a href="{{ route('home') }}" class="btn btn-primary">Quay lại trang chủ</a>
        </div>

    </div>
</section>
@endsection
