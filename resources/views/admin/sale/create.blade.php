

@extends('layout.admin')

@section('content')
<div class="content-wrapper">
      <section class="content-header">
        <h1>
           Thêm mới loại (%) sale <a href="" class="btn btn-primary">Danh sách sale</a>
        </h1>
      </section>
      <section class="content">

        <div class="row container-fluid">
          <div class="col-md-11">
            <div class="box box-primary">
              <form role="form" method="post" action="{{ route('admin.sales.store')}}" enctype="multipart/form-data">
              @csrf
                <div class="box-body">
                  <div class="form-group">
                    <label for="">Nhập phần trăm (%) giảm giá</label>
                    <input type="number" class="form-control" placeholder="Nhập % giảm giá" name="discount_percentage">
                            @error('discount_percentage')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                  </div>
                <div class="box-footer">
                  <button type="submit" name="" class="btn btn-primary">Thêm mới loại giảm giá</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </section>
    </div>




    {{-- <button type="button" id="addVariantBtn" class="btn btn-secondary">Thêm biến thể</button> --}}

@endsection
