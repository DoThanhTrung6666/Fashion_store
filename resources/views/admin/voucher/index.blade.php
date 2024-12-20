@extends('layout.admin')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Danh Sách Voucher
            </h1>
        </section>
        <section class="content">
            <div class="row container-fluid">
                <div class="col-md-11">
                    <div class="box box-primary">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Mã Voucher</th>
                                    <th>Giảm Giá (%)</th>
                                    <th>Giảm Tối Đa</th>
                                    <th>Giá Trị Đơn Hàng Tối Thiểu</th>
                                    <th>Ngày Bắt Đầu</th>
                                    <th>Ngày Kết Thúc</th>
                                    <th>Trạng Thái</th>
                                    <th>Hành Động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vouchers as $voucher)
                                    <tr>
                                        <td>{{ $voucher->name }}</td>
                                        <td>{{ $voucher->discount_percentage }}%</td>
                                        <td>{{ $voucher->max_discount }}</td>
                                        <td>{{ $voucher->min_order_value }}</td>
                                        <td>{{ $voucher->start_date }}</td>
                                        <td>{{ $voucher->end_date }}</td>
                                        <td>{{ $voucher->status == 1 ? 'Chưa bắt đầu' : ($voucher->status == 2 ? 'Đang diễn ra' : 'Đã hết hạn') }}
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.vouchers.edit', $voucher->id) }}"
                                                class="btn btn-warning">Sửa</a>
                                            {{-- <form action="{{ route('admin.vouchers.destroy', $voucher->id) }}" method="POST"
                                                style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Xóa</button>
                                            </form> --}}
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
