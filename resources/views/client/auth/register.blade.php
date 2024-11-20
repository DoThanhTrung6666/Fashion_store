@extends('layout.client')
@section('content')
<div class="gray py-3">
    <div class="container">
        <div class="row">
            <div class="colxl-12 col-lg-12 col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Pages</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Register</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- ======================= Top Breadcrubms ======================== -->

<!-- ======================= Login Detail ======================== -->
<section class="middle">
    <div class="container">
        <div class="login-container">
            <div class="login-image">
                <img src="{{asset('assets/img/bannershop1.jpg')}}" width="100%" height="100%" alt="">
            </div>
            <div class="login-form">
                <h2>Đăng kí tài khoản</h2>
                <form action="{{route('register')}}" method="POST">
                    @csrf
                    <label for="email">Họ và tên</label>
                    <input type="text" id="email" name="name" placeholder="Nhập tên của bạn" >

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Nhập email của bạn" >

                    <label for="password">Mật khẩu</label>
                    <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" >

                    <button type="submit">Đăng kí</button>

                    <div class="forgot">
                        <a href="#">Quên mật khẩu?</a>
                        <a href="{{route('login')}}">Đăng nhập tài khoản</a>
                    </div>
                </form>

                <div class="register">
                    <span>Bạn đã có tài khoản? <a href="{{route('login')}}">Đăng nhập ngay</a></span>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
