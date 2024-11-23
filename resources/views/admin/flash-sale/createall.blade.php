@extends('layout.admin')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Áp dụng Flash Sale cho toàn bộ sản phẩm</h1>
        <span>
            @if(session('success'))
                <p style="color: red">{{session('success')}}</p>
            @endif
        </span>
    </section>
    <section class="content">
        <div class="box">
            <form action="{{ route('admin.flash-salesAll.store') }}" method="POST">
                @csrf
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Chọn % giảm giá</th>
                            <th>Ngày bắt đầu</th>
                            <th>Ngày kết thúc</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select name="sale_id" class="form-control">
                                    <option value="">Chọn % giảm giá</option>
                                    @foreach($sales as $sale)
                                        <option value="{{ $sale->id }}">{{ $sale->name }} - {{ number_format($sale->discount_percentage) }}%</option>
                                    @endforeach
                                </select>
                                @error('sale_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </td>
                            <td>
                                <input type="datetime-local" name="start_time" class="form-control" >
                                @error('start_time')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </td>
                            <td>
                                <input type="datetime-local" name="end_time" class="form-control" >
                                @error('end_time')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button type="submit" class="btn btn-danger">Áp dụng Flash Sale</button>
            </form>
        </div>
    </section>
</div>
@endsection
