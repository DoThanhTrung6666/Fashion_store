
@extends('layout.admin')

@section('content')
<div class="content-wrapper">
            <section class="content-header">
                <h1>
                    Chọn từng sản phẩm Flash sale
                    <a class="btn btn-primary" href="{{route('admin.sales.create')}}">Thêm mới loại sale</a>
                    <a class="btn btn-warning" href="{{route('admin.flash-salesAll.create')}}">Flash Sale toàn bộ</a>
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
                                        <th>Sản phẩm</th>
                                        <th>Các loại giảm giá</th>
                                        <th>Ngày bắt đầu</th>
                                        <th>Ngày kết thúc</th>
                                        <th>Trạng thái</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                        <tr>
                                            <td>
                                                {{ $product->name }}
                                            </td>

                                            <td>
                                                <form action="{{ route('admin.flash-sales.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="product_variant_id" value="{{ $product->id }}">

                                                    <select name="sale_id" class="form-control">
                                                        <option value="">Chọn % giảm giá</option>
                                                        @foreach($sales as $sale)
                                                            <option value="{{ $sale->id }}">{{ $sale->name }} - {{ number_format($sale->discount_percentage) }}%</option>
                                                        @endforeach
                                                    </select>
                                            </td>

                                            <td>
                                                    <input type="datetime-local" name="start_time" class="form-control">
                                            </td>

                                            <td>
                                                    <input type="datetime-local" name="end_time" class="form-control">
                                            </td>

                                            <td>
                                                    <select name="status" class="form-control">
                                                        <option value="active">Active</option>
                                                        <option value="inactive">Inactive</option>
                                                    </select>
                                            </td>

                                            <td>
                                                    <button type="submit" class="btn btn-success">Áp dụng</button>
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
