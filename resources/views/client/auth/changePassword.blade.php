@extends('layout.client')
@section('content')
<div class="gray py-3">
    <div class="container">
        <div class="row">
            <div class="colxl-12 col-lg-12 col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Trang chu</a></li>
                        {{-- <li class="breadcrumb-item"><a href="#">Pages</a></li> --}}
                        <li class="breadcrumb-item active" aria-current="page">Doi mat khau</li>
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
                <h2>Doi mat khau <span>
                    @if(session('error'))
                        <p style="color: red">{{session('error')}}</p>
                    @endif
                </span></h2>
                <form action="{{route('changePassWord')}}" method="POST">
                    @csrf
                    <label for="current_password"></label>
                    <input type="text" id="current_password" name="current_password" placeholder="Nhập mat khau cu" class="@error('current_password') is-invalid @enderror">
                        @error('current_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    <label for="new_password"></label>
                    <input type="password" id="new_password" name="new_password" placeholder="Nhập mật khẩu moi" >

                        @error('new_password')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <label for="new_password_confirmation"></label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" placeholder="Nhập lai mật khẩu moi" >

                        @error('new_password_confirmation')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    <button type="submit">Đoi mat khau</button>

                    <div class="forgot">
                        <a href="{{route('showForgotPassword')}}">Quên mật khẩu?</a>
                        <a href="{{route('register')}}">Đăng ký tài khoản</a>
                    </div>

                </form>

                <div class="register">
                    <span>Chưa có tài khoản? <a href="{{route('register')}}">Đăng ký ngay</a></span>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
