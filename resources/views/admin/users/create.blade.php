@extends('layout.admin')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Thêm mới người dùng <a href="{{ route('admin.users.index')}}" class="btn btn-primary">Danh sách người dùng</a>
            </h1>
        </section>
        <section class="content">

            <div class="row container-fluid">
                <div class="col-md-11">
                    <div class="box box-primary">
                        <form role="form" method="post" action="{{ route('admin.users.store')}}"
                              enctype="multipart/form-data">
                            @csrf
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="">id</label>
                                    <input type="text" class="form-control" placeholder="" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="">Username</label>
                                    <input type="text" class="form-control" placeholder="name" name="name">
                                </div>
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="text" class="form-control" placeholder="Email" name="email">
                                </div>
                                <div class="form-group">
                                    <label for="">Số điện thoại</label>
                                    <input type="text" class="form-control" placeholder="Số điện thoại" name="phone">
                                </div>
                                <div class="form-group">
                                    <label for="">Password</label>
                                    <input type="password" class="form-control" placeholder="Password" name="password">
                                </div>
                                <div class="form-group">
                                    <label for="">Re-Password</label>
                                    <input type="password" class="form-control" placeholder="Re-Password" name="password_confirmation">
                                </div>
                                <div class="form-group">
                                    <label for="">Thành phố</label>
                                    <input type="text" class="form-control" placeholder="Thành phố" name="city">
                                </div>
                                <div class="form-group">
                                    <label for="">Địa chỉ</label>
                                    <input type="text" class="form-control" placeholder="Địa chỉ" name="address">
                                </div>
                                <div class="form-group">
                                    <label for="">Mã zip</label>
                                    <input type="text" class="form-control" placeholder="Mã zip" name="zip_code">
                                </div>
                                <div class="form-group">
                                    <label for="">Phân quyền</label>
                                    <select name="role_id" class="form-control">
                                        @foreach($roles as $role)
                                            <option  value="{{$role->id}}">{{ $role -> name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="box-footer">
                                    <button type="submit" name="createSize" class="btn btn-primary">Thêm mới
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>




    {{-- <button type="button" id="addVariantBtn" class="btn btn-secondary">Thêm biến thể</button> --}}

@endsection
