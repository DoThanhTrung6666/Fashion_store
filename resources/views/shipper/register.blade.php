@extends('layout.admin')

@section('content')
<div class="content-wrapper">
      <section class="content-header">
        {{-- <h1>
          Thêm mới color <a href="{{route('admin.colors.index')}}" class="btn btn-primary">Danh sách sản phẩm</a>
        </h1> --}}
        <span>
          @if(session('success'))
              <p style="color: red">{{session('success')}}</p>
          @endif
      </span>
      </section>
      <section class="content">
        <div class="login-container">
            <div class="login-form">
                <h2>Đăng ki Shipper</h2>

                <form action="{{ route('admin.register.shipper.post') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="username">Tên shipper </label>
                        <input type="text" id="username" name="name"  placeholder="Nhập tên " class="input-field">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="username">Email</label>
                        <input type="text" id="username" name="email"  placeholder="Nhập email" class="input-field">
                        @error('email')
                        <div class="text-danger">{{ $message }}</div>
                  @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Mật Khẩu</label>
                        <input type="password" id="password" name="password"  placeholder="Nhập mật khẩu" class="input-field">
                        @error('password')
                        <div class="text-danger">{{ $message }}</div>
                  @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Số điện thoại</label>
                        <input type="text" id="password" name="phone_number"  placeholder="Nhập số điện thoại" class="form-control">
                        @error('phone_number')
                        <div class="text-danger">{{ $message }}</div>
                  @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Giới tính </label>
                        <select name="gender" id="" class="form-control">
                            <option value="Nam" class="form-control">Nam </option>
                            <option value="Nữ" class="form-control">Nữ  </option>
                        </select>
                        @error('gender')
                        <div class="text-danger">{{ $message }}</div>
                  @enderror
                        {{-- <input type="password" id="password" name="password"  placeholder="Nhập mật khẩu" class="input-field"> --}}
                    </div>
                    <div class="form-group">
                        <label for="password">Ngày sinh </label>
                        <input type="date" id="password" name="date_of_birth"  placeholder="Nhập ngày sinh " class="form-control">
                        @error('date_of_birth')
                        <div class="text-danger">{{ $message }}</div>
                  @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success ">Đăng Kí</button>
                    </div>
                    <span>
                        @if(session('error'))
                            <p style="color: red">{{session('error')}}</p>
                        @endif
                    </span>
                </form>
            </div>
        </div>
        </section>
    </div>




    {{-- <button type="button" id="addVariantBtn" class="btn btn-secondary">Thêm biến thể</button> --}}

    @endsection

