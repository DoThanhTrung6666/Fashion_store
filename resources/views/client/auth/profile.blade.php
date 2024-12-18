
@extends('layout.client')
@section('content')
<!-- ======================= Top Breadcrubms ======================== -->
<div class="gray py-3">
    <div class="container">
        <div class="row">
            <div class="colxl-12 col-lg-12 col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Profile Info</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- ======================= Top Breadcrubms ======================== -->

<!-- ======================= Dashboard Detail ======================== -->
<section class="middle">
    <div class="container">
        <div class="row align-items-start justify-content-between">

            <div class="col-12 col-md-12 col-lg-4 col-xl-4 text-center miliods">
                @if($user)
                <form class="" action="{{route('profile.update',$user->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                <div class="d-block border rounded mfliud-bot">
                    <div class="dashboard_author px-2 py-5">
                        <div class="dash_auth_thumb circle p-1 border d-inline-flex mx-auto mb-2">
                            <img src="{{Storage::url($user->avatar)}}" class="img-fluid circle" width="100" alt="" />
                        </div>
                        <div class="thanhtrung">
                            {{-- <label for="avatar" class="form-label">Upload Avatar</label> --}}
                            <input type="file" id="avatar" name="avatar" accept="image/*">
                            @error('avatar')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="dash_caption">
                            <h4 class="fs-md ft-medium mb-0 lh-1">{{$user->name}}</h4>
                            <span class="text-muted smalls">Việt nam</span>
                        </div>
                    </div>

                    <div class="dashboard_author">
                        <h4 class="px-3 py-2 mb-0 lh-2 gray fs-sm ft-medium text-muted text-uppercase text-left">Tài khoản của tôi</h4>
                        <ul class="dahs_navbar">
                            <li><a href="{{route('orders.loadUser')}}"><i class="lni lni-shopping-basket mr-2"></i>Đơn hàng</a></li>
                            <li><a href="{{route('showFormChangePassWord')}}"><i class="lni lni-map-marker mr-2"></i>Doi mat khau</a></li>
                            {{-- <li><a href="payment-methode.html"><i class="lni lni-mastercard mr-2"></i>Payment Methode</a></li> --}}
                            <li><a href="{{route('logout')}}"><i class="lni lni-power-switch mr-2"></i>Đăng xuất</a></li>
                        </ul>
                    </div>

                </div>
            </div>

            <div class="col-12 col-md-12 col-lg-8 col-xl-8">
                <!-- row -->
                <h4>Tài khoản của tôi </h4>
                @if(session('success'))
                        <p style="color: red">{{session('success')}}</p>
                    @endif
                <div class="row align-items-center">

                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="small text-dark ft-medium">Tên đăng nhập *</label>
                                <input type="text" class="form-control" name="name" placeholder="Nhập tên của bạn" value="{{ old('name', $user->name) }}" />
                                    @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="small text-dark ft-medium">Số điện thoại *</label>
                                <input type="text" class="form-control" name="phone" placeholder="Nhập số điện thoại" value="{{ old('phone', $user->phone) }}"/>
                                    @error('phone')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                            </div>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="small text-dark ft-medium">Email ID *</label>
                                <input type="text" class="form-control" placeholder="Nhập email " name="email" value="{{ old('email', $user->email) }}" />
                                    @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="small text-dark ft-medium">Nhập địa chỉ chi tiết *</label>
                                <input type="text" class="form-control" name="address" placeholder="Nhập địa chỉ " value="{{ old('address', $user->address) }}" />
                                    @error('address')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                            </div>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="small text-dark ft-medium">Mô tả cá nhân *</label>
                                <textarea class="form-control ht-80"></textarea>
                            </div>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-dark">Xác nhận</button>
                            </div>
                        </div>

                    </form>
                    @else
                        <script>
                            window.location.href = "{{ route('home') }}";
                        </script>
                    @endif
                </div>
                <!-- row -->
            </div>

        </div>
    </div>
</section>
<!-- ======================= Dashboard Detail End ======================== -->
@endsection
