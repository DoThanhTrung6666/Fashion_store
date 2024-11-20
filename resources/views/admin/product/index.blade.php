@extends('layout.admin')

@section('content')
<div class="content-wrapper">
            <section class="content-header">
                <h1>
                    Danh sách product <a class="btn btn-primary" href="">Thêm mới product</a>
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
                                    <th style="text-align: center" scope="col" style="">Tên sản phẩm</th>
                                    <th style="text-align: center" scope="col" style="">Image</th>
                                    <th style="text-align: center" scope="col" style="">Giá chung</th>
                                    <th style="text-align: center" scope="col" style="">Số lượng chung</th>
                                    <th style="text-align: center" scope="col" style="">Danh mục</th>
                                </tr>

                               @foreach ($products as $product)

                                            <tr style="text-align: center">
                                                <td><input type="checkbox"></td>
                                                <td>{{$product->id}}</td>
                                                <td>{{$product->name}}</td>
                                                <td><img src="{{Storage::url($product->image)}}" width="100" height="100" alt=""></td>
                                                <td>{{$product->price}}</td>
                                                <td>{{$product->stock_quantity}}</td>
                                                <td>{{$product->category->name}}</td>
                                                <td>
                                                    <a href="{{route('admin.products.edit',$product->id)}}" class="btn btn-warning">Sửa</a>
                                                    <a href="{{route('admin.products.show', $product->id)}}" class="btn btn-info">Xem Chi Tiết</a>
                                                    <a href="" class="btn btn-danger">Xoá</a>
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
