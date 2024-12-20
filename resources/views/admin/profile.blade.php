@extends('layout.admin')
@section('content')
    <div class="content-wrapper">

        <!-- ======================= Top Breadcrubms ======================== -->
        <section class="content-header" style="background-color: #ecf0f5">
            <h1>Thay đổi thông tin tài khoản quản trị</h1>
        </section>
        <!-- ======================= Dashboard Detail ======================== -->
        <section class="middle" style="background-color: #ecf0f5">
            <div class="container">

                <div class="row align-items-start justify-content-between">

                    <div class="col-12 col-md-12 col-lg-4 col-xl-4 text-center miliods">
                        @if($model)
                            <form class="" action="{{route('profile.update',$model->id)}}" method="POST"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="d-block border rounded mfliud-bot">
                                    <div class="dashboard_author px-2 py-5">
                                        <div class="dash_auth_thumb circle p-1 border d-inline-flex mx-auto mb-2">
                                            <img style="width: 300px;height: 400px;"
                                                 src="{{Storage::url($model->avatar)}}" class="img-fluid circle"
                                                 width="100" alt=""/>
                                        </div>
                                        <div class="thanhtrung" style="display: flex;justify-content: center; margin-top: 30px">
                                            {{-- <label for="avatar" class="form-label">Upload Avatar</label> --}}
                                            <input style="width: 300px;background-color: white;color:black;height: 30px" type="file" id="avatar" name="avatar" accept="image/*">
                                            @error('avatar')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
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
                                    <input type="text" class="form-control" name="name" placeholder="Nhập tên của bạn"
                                           value="{{ old('name', $model->name) }}"/>
                                    @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label class="small text-dark ft-medium">Số điện thoại *</label>
                                    <input type="text" class="form-control" name="phone"
                                           placeholder="Nhập số điện thoại" value="{{ old('phone', $model->phone) }}"/>
                                    @error('phone')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label class="small text-dark ft-medium">Email ID *</label>
                                    <input type="text" class="form-control" placeholder="Nhập email " name="email"
                                           value="{{ old('email', $model->email) }}"/>
                                    @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label class="small text-dark ft-medium">Nhập địa chỉ chi tiết *</label>
                                    <input type="text" class="form-control" name="address" placeholder="Nhập địa chỉ "
                                           value="{{ old('address', $model->address) }}"/>
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
                                    <button type="submit" class="btn btn-primary">Xác nhận</button>
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
    </div>
@endsection
