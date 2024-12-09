@extends('layout.admin')

@section('content')
<div class="content-wrapper">
            <section class="content-header">
                <h1 style="margin-bottom: 10px">
                    Danh sách product
                </h1>
                <a class="btn btn-success" href="">Thêm mới product</a>
                <a class="btn btn-warning" href="{{route('admin.listEndProduct')}}">Danh sách sản phẩm ngừng kinh doanh</a>
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
                                    <th style="text-align: center" scope="col" style="">Danh mục</th>
                                </tr>

                               @foreach ($products as $product)

                                            <tr style="text-align: center">
                                                <td><input type="checkbox"></td>
                                                <td>{{$product->id}}</td>
                                                <td>{{$product->name}}</td>

                                                <td><img src="{{ asset('storage/' . $product->image) }}"
                                                    alt="" width="100" height="100"></td>
                                                <td>{{$product->category->name}}</td>
                                                <td>
                                                    <a href="{{route('admin.products.edit',$product->id)}}" class="btn btn-danger">Sửa</a>
                                                    <a href="{{route('admin.products.show', $product->id)}}" class="btn btn-info">Xem Chi Tiết</a>
                                                    <form action="{{ route('admin.product.updateStatus', $product->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-warning">
                                                            Ngừng kinh doanh
                                                        </button>
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
