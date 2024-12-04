
@extends('layout.admin')

@section('content')
<div class="content-wrapper">
            <section class="content-header">
                <h1>
                    Thêm sản phẩm muốn Flash-Sale vào : <strong style="color: red">{{ $flashSale->name }}</strong>
                    {{-- <a class="btn btn-primary" href="{{route('admin.sales.create')}}">Thêm mới loại sale</a> --}}
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
                                        <th style="text-align: center">Chọn</th>
                                        <th style="text-align: center">Tên sản phẩm</th>
                                        <th style="text-align: center">Giá</th>
                                        <th style="text-align: center">Ảnh</th>
                                        <th style="text-align: center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <form action="{{route('admin.save_products',['flashSaleId' => $flashSale->id])}}" method="POST">
                                        @csrf
                                        @foreach($products as $product)
                                        <tr style="text-align: center">
                                            <td>
                                                <!-- Checkbox để chọn sản phẩm -->
                                                <input type="checkbox" name="products_id[]" value="{{ $product->id }}" id="product_{{ $product->id }}"
                                                    @if(in_array($product->id, old('products', []))) checked @endif>
                                            </td>
                                            <td>
                                                {{$product->name}}
                                            </td>
                                            <td>
                                                {{ number_format($product->price)}}
                                            </td>
                                            <td>
                                                <img src="{{Storage::url($product->image)}}" alt="" width="30">
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
