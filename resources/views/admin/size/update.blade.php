
@extends('layout.admin')

@section('content')
<div class="content-wrapper">
      <section class="content-header">
        <h1>
          Cập nhật kích cỡ <a href="{{route('admin.sizes.index')}}" class="btn btn-primary">Danh sách kích cỡ</a>
        </h1>
        <span>
            @if(session('success'))
                <p style="color: green">{{session('success')}}</p>
            @endif
        </span>
      </section>
      <section class="content">

        <div class="row container-fluid">
          <div class="col-md-11">
            <div class="box box-primary">
              <form role="form" method="post" action="{{ route('admin.sizes.update',$size->id)}}" enctype="multipart/form-data">
              @csrf
              @method('PUT')
                <div class="box-body">
                  <div class="form-group">
                    <label for="">Tên size</label>
                    <input type="text" class="form-control" placeholder="Nhập tên size" name="name" value="{{$size->name}}">
                    @error('name')
                          <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                <div class="box-footer">
                  <button type="submit" name="createSize" class="btn btn-primary">Cập nhật kích cỡ</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </section>
    </div>




    {{-- <button type="button" id="addVariantBtn" class="btn btn-secondary">Thêm biến thể</button> --}}

@endsection
