

@extends('layout.admin')

@section('content')
<div class="content-wrapper">
            <section class="content-header">
                <h1 style="color: red">
                    Danh sách Flash Sale : {{$flashSale->name}}
                </h1>
            </section>
            <section class="content">
                <div class="row container-fluid">
                    <div class="col-md-12">
                        <div class="box box-primary">

                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center">Tên sản phẩm</th>
                                            <th style="text-align: center">Giá cũ</th>
                                            <th style="text-align: center">Giá giảm</th>
                                            <th style="text-align: center">Ảnh sản phẩm</th>
                                            <th style="text-align: center">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($flashSale->flashSaleItems as $item)
                                            <tr style="text-align: center">
                                                <td>{{ $item->product->name }}</td>
                                                <td>{{ number_format($item->product->price) }}</td>
                                                <td>{{ number_format($item->price) }}</td>
                                                <td><img src="{{Storage::url($item->product->image)}}" width="30" alt=""></td>
                                                <td>
                                                    <form action="{{route('admin.delete_product',[$flashSale->id,$item->id])}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger">Xoá sản phẩm khỏi danh sách flash-sale</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
@endsection
