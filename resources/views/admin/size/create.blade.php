
@extends('layout.admin')

@section('content')
<div class="content-wrapper">
      <section class="content-header">
        <h1 style="text-align:center">
          Thêm mới kích cỡ
        </h1>
      </section>
      <section class="content">

        <div class="row container-fluid">
          <div class="col-md-12">
            <div class="box box-primary">
              <form role="form" method="post" action="{{ route('admin.sizes.store')}}" enctype="multipart/form-data">
              @csrf
                <div class="box-body">
                  {{-- <div class="form-group">
                    <label for="">id</label>
                    <input type="text" class="form-control" placeholder="" disabled>
                  </div> --}}
                  <div class="form-group">
                    <label for="">Tên size</label>
                    <input type="text" class="form-control" placeholder="Nhập tên size" name="name">
                    @error('name')
                          <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                <div class="box-footer">
                  <button type="submit" name="createSize" class="btn btn-success">Thêm mới kích cỡ</button>
                  <a href="{{route('admin.sizes.index')}}" class="btn btn-drak">Danh sách kích cỡ</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </section>
    </div>




    {{-- <button type="button" id="addVariantBtn" class="btn btn-secondary">Thêm biến thể</button> --}}

@endsection
