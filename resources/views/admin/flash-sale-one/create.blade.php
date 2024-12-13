
@extends('layout.admin')

@section('content')
<div class="content-wrapper">
      <section class="content-header">
        <h1>
          Thêm Flash-Sale mới
        </h1>
      </section>
            <span>
                @if(session('success'))
                    <p style="color: red">{{session('success')}}</p>
                @endif
            </span>
      <section class="content">

        <div class="row container-fluid">
          <div class="col-md-11">
            <div class="box box-primary">
              <form role="form" method="post" action="{{ route('admin.storeFlashSale')}}" enctype="multipart/form-data">
              @csrf
                <div class="box-body">
                    <div class="form-group">
                        <label for="">Tên Flash-Sale</label>
                        <input type="text" class="form-control" name="name" placeholder="Ví dụ:Giảm giá mùa đông">
                            @error('name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Phần trăm giảm giá (%)</label>
                        <select name="sale_id" id="" class="form-control">
                            @foreach ($sales as $sale)
                                <option  value="{{$sale->id}}">{{number_format($sale->discount_percentage)}}</option>
                            @endforeach
                        </select>
                            @error('sale_id')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label for="start_time">Thời gian bắt đầu</label>
                        <input type="datetime-local" name="start_time" class="form-control">
                            @error('start_time')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label for="end_time">Thời gian kết thúc</label>
                        <input type="datetime-local" name="end_time" class="form-control">
                            @error('end_time')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                    </div>
                    <div class="box-footer">
                        <button type="submit" name="" class="btn btn-success">Tạo FlashSale</button>
                        <a href="{{route('admin.listFlashSale')}}" class="btn btn-primary">Danh sách Flash-sale</a>
                    </div>
              </form>
            </div>
          </div>
        </div>
      </section>
    </div>




    {{-- <button type="button" id="addVariantBtn" class="btn btn-secondary">Thêm biến thể</button> --}}

@endsection
