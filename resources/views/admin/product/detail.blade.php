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
                                    {{-- <th style="text-align: center" scope="col" style="">Thao tác<th> --}}
                                </tr>


                                    @foreach ($product->variants as $variant)
                                            <tr style="text-align: center">
                                                {{-- <td><input type="checkbox"></td> --}}
                                                {{-- <td>{{$product->id}}</td> --}}
                                                <td><p class="custom-name">{{$product->name}}</p>
                                                </td>
                                                <td><img class="img-square" src="{{Storage::url($variant->image_variant)}}" width="100" alt=""></td>
                                                {{-- <td>{{$product->category->name}}</td> --}}
                                                <td><p class="custom-name">{{$variant->color->name}}</p></td>
                                                <td><p class="custom-name">{{$variant->size->name}}</p></td>
                                                <td><p class="custom-name">{{number_format($variant->product->price)}}đ</p></td>
                                                <td><p class="custom-name">{{$variant->stock_quantity}}</p></td>
                                                <td>
                                                    {{-- <a href="{{route('admin.products.edit',$product->id)}}" class="btn btn-warning">Sửa</a> --}}
                                                    <form action="{{route('admin.variants.destroy',$variant->id)}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit">Xoá</button>
                                                    </form>
                                                </td>
                                            </tr>
                                    @endforeach

                            </table>
                                    <a class="" href="{{ route('admin.products.variants.create', $product->id) }}"><i class="fas fa-plus-circle" style="color: greenyellow"></i> Thêm biến thể mới</a><br><br>
                                    <a href="{{route('admin.products.edit',$product->id)}}" class=""> <i class="fas fa-edit" style=" color: #dfe837;"></i> Sửa</a><br><br>
                                    <a href="{{route('admin.products.index')}}" class="" style="color: black"><i class="fas fa-arrow-left"></i> Quay lại</a>
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
.custom-badge {
    display: inline-block;
    padding: 5px 10px;
    background-color: #f8f9fa; /* Màu nền */
    color: #333; /* Màu chữ */
    border-radius: 5px; /* Góc bo tròn */
    font-size: 14px; /* Kích thước chữ */
    font-weight: bold;
    border: 1px solid #ddd; /* Viền */
}
.custom-name {
    display: inline-block;
    padding: 5px 5px;
    background-color: #f8f9fa; /* Màu nền */
    color: #333; /* Màu chữ */
    border-radius: 5px; /* Góc bo tròn */
    font-size: 14px; /* Kích thước chữ */
    font-weight: bold;
    border: 1px solid #ddd; /* Viền */
}

</style>

