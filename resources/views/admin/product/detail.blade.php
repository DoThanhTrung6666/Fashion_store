@extends('layout.admin')

@section('content')
<div class="content-wrapper">
            <section class="content-header">
                <h1>
                    Danh sách biến thể sản phẩm <a class="btn btn-success" href="">Thêm biến thể mới</a>
                </h1>
            </section>
            <section class="content">
                <div class="row container-fluid">
                    <div class="col-md-12">
                        <div class="box box-primary">
                            @if ($product)
                            <table class="table">
                                <tr>
                                    <th style="text-align: center" scope="col" style=""></th>
                                    <th style="text-align: center" scope="col" style="">id</th>
                                    <th style="text-align: center" scope="col" style="">Tên sản phẩm</th>
                                    <th style="text-align: center" scope="col" style="">Image</th>
                                    <th style="text-align: center" scope="col" style="">Danh mục</th>
                                    <th style="text-align: center" scope="col" style="">Màu sắc</th>
                                    <th style="text-align: center" scope="col" style="">Kích cỡ</th>
                                    <th style="text-align: center" scope="col" style="">Giá sản phẩm</th>
                                    <th style="text-align: center" scope="col" style="">Số lượng<th>
                                </tr>


                                    @foreach ($product->variants as $variant)
                                            <tr style="text-align: center">
                                                <td><input type="checkbox"></td>
                                                <td>{{$product->id}}</td>
                                                <td>{{$product->name}}</td>
                                                <td><img src="{{Storage::url($variant->image_variant)}}" width="100" alt=""></td>
                                                <td>{{$product->category->name}}</td>
                                                <td>{{$variant->color->name}}</td>
                                                <td>{{$variant->size->name}}</td>
                                                <td>{{$variant->product->price}}</td>
                                                <td>{{$variant->stock_quantity}}</td>
                                                <td>
                                                    <a href="{{route('admin.products.edit',$product->id)}}" class="btn btn-warning">Sửa</a>
                                                    <a href="" class="btn btn-danger">Xoá</a>
                                                </td>
                                            </tr>
                                    @endforeach


                            </table>
                            @else
                                <p>Sản phẩm không tồn tại.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        </div>
@endsection
