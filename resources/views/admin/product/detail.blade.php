@extends('layout.admin')

@section('content')
<div class="content-wrapper">
            <section class="content-header">
                <h1>
                    Danh sách biến thể sản phẩm
                </h1>
            </section>
            <section class="content">
                <div class="row container-fluid">
                    <div class="col-md-12">
                        <div class="box box-primary">
                            @if ($product)
                            <table class="table">
                                <tr>
                                    {{-- <th style="text-align: center" scope="col" style=""></th> --}}
                                    {{-- <th style="text-align: center" scope="col" style="">id</th> --}}
                                    <th style="text-align: center" scope="col" style="">Tên sản phẩm</th>
                                    <th style="text-align: center" scope="col" style="">Image</th>
                                    {{-- <th style="text-align: center" scope="col" style="">Danh mục</th> --}}
                                    <th style="text-align: center" scope="col" style="">Màu sắc</th>
                                    <th style="text-align: center" scope="col" style="">Kích cỡ</th>
                                    <th style="text-align: center" scope="col" style="">Giá sản phẩm</th>
                                    <th style="text-align: center" scope="col" style="">Số lượng<th>
                                </tr>


                                    @foreach ($product->variants as $variant)
                                            <tr style="text-align: center">
                                                {{-- <td><input type="checkbox"></td> --}}
                                                {{-- <td>{{$product->id}}</td> --}}
                                                <td><p class="badge rounded-pill" style="color:black; background-color: aqua;">{{$product->name}}</p>
                                                </td>
                                                <td><img class="img-square" src="{{Storage::url($variant->image_variant)}}" width="100" alt=""></td>
                                                {{-- <td>{{$product->category->name}}</td> --}}
                                                <td>{{$variant->color->name}}</td>
                                                <td>{{$variant->size->name}}</td>
                                                <td>{{number_format($variant->product->price)}}đ</td>
                                                <td>{{$variant->stock_quantity}}</td>
                                                <td>
                                                    {{-- <a href="{{route('admin.products.edit',$product->id)}}" class="btn btn-warning">Sửa</a> --}}
                                                    {{-- <a href="" class="btn btn-danger">Xoá</a> --}}
                                                </td>
                                            </tr>
                                    @endforeach

                            </table>
                                    <a class="" href=""><i class="fas fa-plus-circle" style="color: greenyellow"></i> Thêm biến thể mới</a><br><br>
                                    <a href="{{route('admin.products.edit',$product->id)}}" class=""> <i class="fas fa-edit" style=" color: #007bff;"></i> Sửa</a>
                            @else
                                <p>Sản phẩm không tồn tại.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        </div>
@endsection
<style>
    .img-square {
    width: 100px; /* Chiều rộng cố định */
    height: 100px; /* Chiều cao cố định */
    object-fit: cover; /* Đảm bảo ảnh sẽ phủ kín khung mà không bị biến dạng */
    object-position: center; /* Căn giữa ảnh nếu nó không vừa khung */
}
</style>
