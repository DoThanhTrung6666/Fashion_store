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
<section class="">
    <div class="container">
        <div class="login-container">
            <div class="login-image">
                <img src="{{asset('assets/img/bannershop1.jpg')}}" width="100%" height="100%" alt="">
            </div>
            <div class="login-form">
                <h2>Đăng kí tài khoản</h2>
                <span style="font-size: 10px">
                    @if(session('error'))
                        <p style="color: red">{{session('error')}}</p>
                    @endif
                </span>
                <span style="font-size: 10px">
                    @if(session('success'))
                        <p style="color: red">{{session('success')}}</p>
                    @endif
                </span>
                <form action="{{route('register')}}" method="POST">
                    @csrf

                        <label for="name">
                        </label>
                        <input type="text" id="name" name="name" placeholder="Nhập tên của bạn" >
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror

                        <label for="email"></label>
                        <input type="email" id="email" name="email" placeholder="Nhập email của bạn" >
                        @error('email')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror




                        <label for="password"></label>
                        <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" >
                        @error('password')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror



                    <button type="submit">Đăng kí</button>
                </form>

                <div class="register">
                    <span>Bạn đã có tài khoản? <a href="{{route('login')}}">Đăng nhập ngay</a></span>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
