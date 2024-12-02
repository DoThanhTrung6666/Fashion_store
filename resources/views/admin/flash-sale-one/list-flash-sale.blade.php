
@extends('layout.admin')

@section('content')
<div class="content-wrapper">
            <section class="content-header">
                <h1>
                    Danh sách Flash Sale <a class="btn btn-primary" href="{{route('admin.createFlashSale')}}">Thêm mới Flash-sale</a>
                </h1>
            </section>
            <section class="content">
                <div class="row container-fluid">
                    <div class="col-md-12">
                        <div class="box box-primary">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center">Tên Flash-Sale</th>
                                            <th style="text-align: center">% giảm giá</th>
                                            <th style="text-align: center">Thời gian bắt đầu</th>
                                            <th style="text-align: center">Thời gian kết thúc</th>
                                            <th style="text-align: center">Status</th>
                                            <th style="text-align: center">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($flashSales as $flashSale)
                                            <tr style="text-align: center">
                                                <td>{{ $flashSale->name }}</td>
                                                <td>{{ number_format($flashSale->sale->discount_percentage) }} %</td>
                                                <td>{{ $flashSale->start_time}}</td>
                                                <td>{{ $flashSale->end_time}}</td>
                                                <td>{{ $flashSale->status}}</td>
                                                <td>
                                                    <a href="{{ route('admin.add_products', $flashSale->id) }}" class="btn btn-success">Chọn sản phẩm áp dụng</a>
                                                    <a href="{{ route('admin.view_products',$flashSale->id)}}" class="btn btn-warning">Xem tất cả sản phẩm đã áp dụng</a>
                                                    <a href="" class="btn btn-danger">Sửa</a>
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
