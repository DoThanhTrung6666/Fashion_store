@extends('layout.admin')

@section('content')
<div class="content-wrapper">
            <section class="content-header">
                <h1>
                    Danh sách người dùng <a class="btn btn-primary" href="">Thêm mới người dùng</a>
                </h1>
            </section>
            <section class="content">
                <div class="row container-fluid">
                    <div class="col-md-12">
                        <div class="box box-primary">

                            <table class="table">
                                <tr>
                                    <th style="text-align: center" scope="col" style=""></th>
                                    <th style="text-align: center" scope="col" style="">id</th>
                                    <th style="text-align: center" scope="col" style="">Username</th>
                                    <th style="text-align: center" scope="col" style="">Email</th>
                                    <th style="text-align: center" scope="col" style="">Số điện thoại</th>
                                    <th style="text-align: center" scope="col" style="">Địa chỉ</th>
                                    <th style="text-align: center" scope="col" style="">Thành phố</th>
                                    <th style="text-align: center" scope="col" style="">Mã Zip</th>
                                    <th style="text-align: center" scope="col" style="">Quyền</th>
                                </tr>
                                            <tr style="text-align: center">
                                                <td><input type="checkbox"></td>
                                                <td>{{$model->id}}</td>
                                                <td>{{$model->username}}</td>
                                                <td>{{$model->email}}</td>
                                                <td>{{$model->phone}}</td>
                                                <td>{{$model->address}}</td>
                                                <td>{{$model->city}}</td>
                                                <td>{{$model->zip_code}}</td>
                                                <td>{{$model->role_id == 1 ? 'Admin' : 'User'}}</td>
                                                <td>
                                                    <a href="{{route('admin.users.edit',$model->id)}}" class="btn btn-warning">Sửa</a>
                                                    <a href="" class="btn btn-danger">Xoá</a>
                                                </td>
                                            </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
@endsection
