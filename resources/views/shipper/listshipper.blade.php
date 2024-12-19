@extends('layout.admin')

@section('content')
<div class="content-wrapper">
            <section class="content-header">
                <h1 style="margin-bottom: 10px; text-align:center">
                    Danh sách shipper 
                </h1>
                {{-- <div class="gray py-3">
                    <div class="row">
                        <div class="colxl-12 col-lg-12 col-md-12">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('admin.products.index')}}">Danh sách sản phẩm đang bán</a></li>
                                    <li class="breadcrumb-item"><a href="{{route('admin.listEndProduct')}}">Danh sách sản phẩm ngừng bán</a></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div> --}}
            </section>
            <section class="content">
                <div class="row container-fluid">
                    <div class="col-md-12">
                        <div class="box box-primary">

                            <table class="table">
                                <tr>
                                    {{-- <th style="text-align: center" scope="col" style=""></th> --}}
                                    {{-- <th style="text-align: center" scope="col" style="">id</th> --}}
                                    <th style="text-align: center" scope="col" style="">Tên sản phẩm</th>
                                    <th style="text-align: center" scope="col" style="">Image</th>
                                    <th style="text-align: center" scope="col" style="">Giá sản phẩm</th>
                                    <th style="text-align: center" scope="col" style="">Thương hiệu</th>
                                    <th style="text-align: center" scope="col" style="">Danh mục</th>
                                </tr>

                               @foreach ($products as $product)

                                            <tr style="text-align: center">
                                                {{-- <td><input type="checkbox"></td> --}}
                                                {{-- <td>{{$product->id}}</td> --}}
                                                <td>{{$product->name}}</td>
                                                <td><img src="{{Storage::url($product->image)}}" width="50" alt=""></td>
                                                <td><p class="custom-badge">{{number_format($product->price)}}đ</p></td>
                                                <td><p class="custom-name">{{$product->brand->name}}</p></td>
                                                <td>{{$product->category->name}}</td>
                                                <td>
                                                    {{-- <a href="{{route('admin.products.edit',$product->id)}}" class="btn btn-danger">Sửa</a> --}}
                                                    <a href="{{route('admin.products.show', $product->id)}}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                                    <form action="{{ route('admin.product.updateStatus', $product->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-warning">
                                                            Tiếp tục bán
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>


                               @endforeach
                            </table>
                            <a href="{{route('admin.products.index')}}"><i class="ti-back-left mr-2"></i> Quay lại</a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
@endsection
