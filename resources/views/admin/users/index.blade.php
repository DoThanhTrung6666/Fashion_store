@extends('layout.admin')

@section('content')

<div class="content-wrapper">
            <section class="content-header">
                <h1>
                    Danh sách người dùng <a class="btn btn-primary" href="{{ route('admin.users.create') }}">Thêm mới người dùng</a>
                </h1>
            </section>
            <section class="content">
                <div class="row container-fluid">
                    <div class="col-md-12">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="box box-primary">

                            <table class="table">
                                <tr>
                                    <th style="text-align: center" scope="col" style=""></th>
                                    <th style="text-align: center" scope="col" style="">id</th>
                                    <th style="text-align: center" scope="col" style="">Tên tài khoản</th>
                                    <th style="text-align: center" scope="col" style="">Email</th>
                                    <th style="text-align: center" scope="col" style="">Số điện thoại</th>
                                    <th style="text-align: center" scope="col" style="">Địa chỉ</th>
                                    <th style="text-align: center" scope="col" style="">Thành phố</th>
                                    <th style="text-align: center" scope="col" style="">Mã Zip</th>
                                    <th style="text-align: center" scope="col" style="">Quyền</th>
                                </tr>
                               @foreach ($users as $user)
                               <tr>
                                <td style="text-align: center"><input type="checkbox"></td>
                                <td style="text-align: center">{{$user->id}}</td>
                                <td style="text-align: center">{{$user->name}}</td>
                                <td style="text-align: center">{{$user->email}}</td>
                                <td style="text-align: center">{{$user->phone}}</td>
                                <td style="text-align: center">{{$user->address}}</td>
                                <td style="text-align: center">{{$user->city}}</td>
                                <td style="text-align: center">{{$user->zip_code}}</td>
                                <td style="text-align: center">{{$user->getNameRole()}}</td>
                                <td style="text-align: center">
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning">Sửa</a>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa người dùng này không?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Khóa tài khoản</button>
                                    </form>

                                </td>
                                </tr>
                               @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
@endsection
