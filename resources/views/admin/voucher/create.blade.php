@extends('layout.admin')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Thêm Voucher
            </h1>
        </section>
        <section class="content">
            <div class="row container-fluid">
                <div class="col-md-11">
                    <div class="box box-primary">
                        <form action="{{ route('admin.vouchers.store') }}" method="POST">
                            @csrf
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="name" class="form-label">Mã Voucher</label>
                                    <input type="text" name="name" id="name" class="form-control">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="discount_percentage" class="form-label">Giảm Giá (%)</label>
                                    <input type="number" name="discount_percentage" id="discount_percentage"
                                        class="form-control">
                                    @error('discount_percentage')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="max_discount" class="form-label">Giá Giảm Tối Đa</label>
                                    <input type="number" name="max_discount" id="max_discount" class="form-control">
                                    @error('max_discount')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="min_order_value" class="form-label">Giá Trị Đơn Hàng Tối Thiểu</label>
                                    <input type="number" name="min_order_value" id="min_order_value" class="form-control">
                                    @error('min_order_value')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="start_date" class="form-label">Ngày Bắt Đầu</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control">
                                    @error('start_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="end_date" class="form-label">Ngày Kết Thúc</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control">
                                    @error('end_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Lưu Voucher</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
