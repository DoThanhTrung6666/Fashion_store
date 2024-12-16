@extends('layout.admin')

@section('content')
<div class="content-wrapper">
            <section class="content-header">
                <h1 style="margin-bottom: 10px">
                    Danh sách sản phẩm
                </h1>
            </section>
            <section class="content">
                <div class="row container-fluid">
                    <div class="col-md-12">
                        <div class="box box-primary">

                            <table class="table">
                                <tr>
                                    {{-- <th style="text-align: center" scope="col" style=""></th> --}}
                                    <th style="text-align: center" scope="col" style="">id</th>
                                    <th style="text-align: center" scope="col" style="">Tên sản phẩm</th>
                                    <th style="text-align: center" scope="col" style="">Giá sản phẩm</th>
                                    <th style="text-align: center" scope="col" style="">Thương hiệu sản phẩm</th>
                                    <th style="text-align: center" scope="col" style="">Ảnh sản phẩm</th>
                                    <th style="text-align: center" scope="col" style="">Danh mục</th>
                                </tr>

                               @foreach ($products as $product)

                                            <tr style="text-align: center">
                                                {{-- <td><input type="checkbox"></td> --}}
                                                <td><p> {{$product->id}}</p></td>
                                                <td><p class="custom-name">{{$product->name}}</p></td>
                                                <td><p class="custom-badge">{{number_format($product->price)}}đ</p></td>
                                                <td><p class="custom-name">{{$product->brand->name}}</p></td>
                                                <td><img class="img-square" src="{{ asset('storage/' . $product->image) }}"
                                                    alt="" ></td>
                                                <td><p class="custom-name">{{$product->category->name}}</p></td>
                                                <td>
                                                    {{-- <a href="{{route('admin.products.edit',$product->id)}}" class=""><i class="fas fa-edit"></i></a> --}}
                                                    <a href="{{route('admin.products.show', $product->id)}}" class="btn btn-warning"><i class="fas fa-eye"></i></a>
                                                    <form action="{{ route('admin.product.updateStatus', $product->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>


                               @endforeach
                            </table>
                            <hr>
                            <a class="btn btn-success" href=""><i class="fas fa-plus-circle" style="color: greenyellow"></i> Thêm sản phẩm mới</a><br><br>
                            <a class="btn btn-warning" href="{{route('admin.listEndProduct')}}" ><i class="fas fa-list" style="color: rgb(157, 157, 2)"></i> Sản phẩm ngừng kinh doanh</a>
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
