
@extends('layout.admin')

@section('content')
<div class="content-wrapper">
      <section class="content-header">
        <h1>
          Cập nhật color <a href="{{route('admin.colors.index')}}" class="btn btn-primary">Danh sách color </a>
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
              <form role="form" method="post" action="{{ route('admin.colors.update',$color->id)}}" enctype="multipart/form-data">
              @csrf
              @method('PUT')
                <div class="box-body">
                  <div class="form-group">
                    <label for="">id</label>
                    <input type="text" class="form-control" placeholder="" disabled>
                  </div>
                  <div class="form-group">
                    <label for="">Tên color</label>
                    <input type="text" class="form-control" placeholder="Nhập tên color" name="name" value="{{$color->name}}">
                      @error('name')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                  </div>
                <div class="box-footer">
                  <button type="submit" name="" class="btn btn-primary">Cập nhật color</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </section>
    </div>




    {{-- <button type="button" id="addVariantBtn" class="btn btn-secondary">Thêm biến thể</button> --}}

@endsection
