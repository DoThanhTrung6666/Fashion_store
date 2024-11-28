
@extends('layout.admin')

@section('content')
<div class="content-wrapper">
            <section class="content-header">
                <h1>
                    Chọn sản phẩm muốn Flash sale
                    <a class="btn btn-primary" href="{{route('admin.sales.create')}}">Thêm mới loại sale</a>
                    <a class="btn btn-warning" href="">Flash Sale toàn bộ</a>
                    <a href="" class="btn btn-danger">Danh sách sản phẩm đã chọn flash-sale</a>
                </h1>
                <span>
                    @if(session('success'))
                        <p style="color: red">{{session('success')}}</p>
                    @endif
                </span>
                <span>
                    @if(session('error'))
                        <p style="color: red">{{session('error')}}</p>
                    @endif
                </span>
            </section>
            <section class="content">
                <div class="row container-fluid">
                    <div class="col-md-12">
                        <div class="box box-primary">

                            <h3>Tạo Flash Sale cho các sản phẩm đã chọn</h3>

                            <form action="{{route('admin.apply')}}" method="POST">
                                @csrf

                                <!-- Các trường thời gian và % Sale nằm trên cùng một dòng -->
                                <div class="form-row">
                                    {{-- Tên giảm giá  --}}
                                    <div class="form-group col-md-3">
                                        <label for="">Tên flash_sale</label>
                                        <input type="text" name="name" id="" class="form-control" required>
                                    </div>
                                    <!-- Chọn đợt giảm giá -->
                                    <div class="form-group col-md-3">
                                        <label for="sale_id">Chọn đợt giảm giá (% Sale):</label>
                                        <select name="sale_id" id="sale_id" class="form-control">
                                            @foreach($sales as $sale)
                                                <option value="{{ $sale->id }}">{{ $sale->name }} ({{ number_format($sale->discount_percentage) }}%)</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Thời gian bắt đầu -->
                                    <div class="form-group col-md-3">
                                        <label for="start_time">Thời gian bắt đầu:</label>
                                        <input type="datetime-local" name="start_time" id="start_time" class="form-control" required>
                                    </div>

                                    <!-- Thời gian kết thúc -->
                                    <div class="form-group col-md-3">
                                        <label for="end_time">Thời gian kết thúc:</label>
                                        <input type="datetime-local" name="end_time" id="end_time" class="form-control" required>
                                    </div>
                                    <!-- Trạng thái -->
                                        {{-- <div class="form-group col-md-3">
                                            <label for="status">Trạng thái:</label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="active">Kích hoạt</option>
                                                <option value="inactive">Hủy bỏ</option>
                                            </select>
                                        </div> --}}
                                </div>

                                <!-- Bảng hiển thị các sản phẩm đã chọn -->
                                <table class="table table-bordered mt-3">
                                    <thead>
                                        <tr>
                                            <th>Sản phẩm</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($selectedProducts as $item)
                                            <tr>
                                                <td>{{ $item->product->name }}</td>
                                            </tr>
                                        @endforeach

                                    </tbody>

                                </table>

                                <button type="submit" class="btn btn-primary mt-3">Tạo Flash Sale</button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>


@endsection
