
@extends('layout.admin')

@section('content')
<div class="content-wrapper">
            <section class="content-header">
                <h1>
                    Chọn sản phẩm muốn Flash sale
                    <a class="btn btn-primary" href="{{route('admin.sales.create')}}">Thêm mới loại sale</a>
                    <a class="btn btn-warning" href="{{route('admin.flash-salesAll.create')}}">Flash Sale toàn bộ</a>
                    <a href="{{route('admin.flash-sales.create')}}" class="btn btn-danger">Danh sách sản phẩm đã chọn flash-sale</a>
                </h1>
                <span>
                    @if(session('success'))
                        <p style="color: red">{{session('success')}}</p>
                    @endif
                </span>
            </section>
            <section class="content">
                <div class="row container-fluid">
                    <div class="col-md-12">
                        <div class="box box-primary">

                            <table class="table table-bordered" id="flashSaleTable">
                                <thead>
                                    <tr>
                                        <th>Chọn</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Giá</th>
                                        {{-- <th>Ảnh</th> --}}
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <form action="{{ route('admin.storeSelectFlashSale') }}" method="POST">
                                        @csrf
                                    @foreach($products as $product)
                                        <tr>
                                            <td>
                                                <!-- Checkbox để chọn sản phẩm -->
                                                <input type="checkbox" name="products[]" value="{{ $product->id }}" id="product_{{ $product->id }}"
                                                    @if(in_array($product->id, old('products', []))) checked @endif>
                                            </td>
                                            <td>
                                                {{$product->name}}
                                            </td>
                                            <td>
                                                {{$product->price}}
                                            </td>
                                            <td>
                                                <a href="" class="btn btn-facebook">Xem chi tiết sản phẩm</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-danger">Xác nhận sản phẩm muốn Flash-Sale</button>
                        </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>


@endsection
