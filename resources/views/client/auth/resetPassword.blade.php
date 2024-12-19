@extends('layout.client')
@section('content')
    <div class="gray py-3">
        <div class="container">
            <div class="row">
                <div class="colxl-12 col-lg-12 col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Pages</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Login</li>
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
                    <img src="{{ asset('assets/img/bannershop1.jpg') }}" width="100%" height="100%" alt="">
                </div>
                <div class="login-form">
                    <h2>Đặt lại mật khẩu</h2>
                    <form action="{{ route('resetPassword') }}" method="POST" class="mt-3">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ $email }}" readonly>
                        </div>
                        <!-- Nhập mã OTP -->
                        <div class="mb-3">
                            <label for="otp" class="form-label">Nhập mã OTP</label>
                            <input type="number" id="otp" name="otp"
                                class="form-control @error('otp') is-invalid @enderror" placeholder="Nhập mã OTP tại đây"
                                value="{{ old('otp') }}">
                            @error('otp')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Nhập mật khẩu mới -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu mới</label>
                            <input type="password" id="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Nhập mật khẩu mới">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Nhập lại mật khẩu -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Nhập lại mật khẩu mới</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                placeholder="Nhập lại mật khẩu mới">
                            @error('password_confirmation')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <button type="submit" class="btn-gray">Đặt lại mật khẩu</button>
                    </form>

                    <div class="register">
                        <span>Quay lại trang đăng nhập? <a href="{{ route('login') }}">Đăng nhập</a></span>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
