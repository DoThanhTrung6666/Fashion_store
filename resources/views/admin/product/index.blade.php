@extends('layout.admin')

@section('content')
<div class="content-wrapper">
            <section class="content-header">
                <h1 style="margin-bottom: 10px ; text-align:center">
                    <b>Danh sách sản phẩm</b>
                </h1>
                <span>
                    @if(session('success'))
                        <p style="color: green">{{session('success')}}</p>
                    @endif
                </span>
            </section>
            <section class="content">
                <div class="row container-fluid">
                    <div class="col-md-12">
                        <div class="search-bar">
                            <form action="{{route('admin.search.product')}}" method="GET">
                                @csrf
                                <div style="display:flex">
                                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Bạn có thể tìm kiếm theo ID hoặc Tên Sản phẩm">
                                    <input type="submit" style="width:100px" value="Tìm kiếm">
                                </div>
                            </form>
                        </div>
                        <div class="box box-success">

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
                                                <td><p class="">{{$product->name}}</p></td>
                                                <td><p class="">{{number_format($product->price)}}đ</p></td>
                                                <td><p class="">{{$product->brand->name}}</p></td>
                                                <td><img class="img-square" src="{{ asset('storage/' . $product->image) }}"
                                                    alt="" ></td>
                                                <td><p class="">{{$product->category->name}}</p></td>
                                                <td>
                                                    {{-- <a href="{{route('admin.products.edit',$product->id)}}" class=""><i class="fas fa-edit"></i></a> --}}
                                                    <a href="{{route('admin.products.show', $product->id)}}" class="btn btn-info btn-sm" style="color: white;"><i class="fas fa-eye"></i></a>
                                                    <form action="{{ route('admin.product.updateStatus', $product->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-secondary btn-sm" style="border: none;color:white;">
                                                            <i class="fas fa-ban"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>


                               @endforeach

                            </table>
                            <div style="text-align: center; ">{{ $products->links() }}</div>

                            <hr>
                            <div style="display:flex">
                                <a style="margin-bottom: 10px; margin-left:10px" class="btn btn-success btn-sm" style="color: white;" href=""><i class="fas fa-plus-circle" style="color: greenyellow"></i> Thêm sản phẩm mới</a><br><br>
                                <a style="margin-bottom: 10px; margin-left:10px" class="btn btn-warning btn-sm" style="color: white;" href="{{route('admin.listEndProduct')}}" ><i class="fas fa-list" style="color: rgb(157, 157, 2)"></i> Sản phẩm ngừng kinh doanh</a>
                            </div>
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
/* Nút xem chi tiết */
.btn-info {
    background-color: #3498db; /* Màu xanh dương */
    border-color: #2980b9; /* Viền màu đậm hơn */
}

.btn-info:hover {
    background-color: #2980b9; /* Màu xanh dương đậm khi hover */
    border-color: #3498db;
}

/* Nút sửa */
.btn-warning {
    background-color: #f39c12; /* Màu vàng */
    border-color: #e67e22;
}

.btn-warning:hover {
    background-color: #e67e22;
    border-color: #f39c12;
}

/* Nút ngừng kinh doanh */
.btn-secondary {
    background-color: #7f8c8d; /* Màu xám */
    border-color: #95a5a6;
}

.btn-secondary:hover {
    background-color: #95a5a6;
    border-color: #7f8c8d;
}

/* Nút xóa */
.btn-danger {
    background-color: #e74c3c; /* Màu đỏ */
    border-color: #c0392b;
}

.btn-danger:hover {
    background-color: #c0392b;
    border-color: #e74c3c;
}
table {
    border-collapse: collapse;
    width: 100%;
    background-color: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

th, td {
    padding: 12px 15px;
    text-align: center;
    border-bottom: 1px solid #ddd;
}

tr:hover {
    background-color: #f4f4f4;
}

</style>
