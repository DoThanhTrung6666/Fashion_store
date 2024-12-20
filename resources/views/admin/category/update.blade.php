@extends('layout.admin')

@section('content')
<div class="content-wrapper">
  <section class="content-header">
      <h1>Sửa danh mục</h1>
  </section>

  <section class="content">
      <div class="row container-fluid">
          <div class="col-md-11">
              <!-- Thêm phần hiển thị thông báo -->
              @if (session('success'))
                  <div class="alert alert-success alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      {{ session('success') }}
                  </div>
              @endif

              @if (session('error'))
                  <div class="alert alert-danger alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      {{ session('error') }}
                  </div>
              @endif

              <!-- Form sửa danh mục -->
              <div class="box box-primary">
                  <form role="form" method="post" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data">
                      @csrf
                      @method('PUT')
                      <div class="box-body">
                        <div class="form-group">
                          <label for="name">Tên danh mục</label>
                          <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" placeholder="Nhập tên danh mục" name="name" value="{{ old('name', $category->name) }}">
                          
                          @if ($errors->has('name'))
                              <span class="text-danger">{{ $errors->first('name') }}</span>
                          @endif
                      </div>
                      </div>
                      <div class="box-footer">
                          <button type="submit" class="btn btn-primary">Cập nhật</button>
                          <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">Danh sách danh mục</a>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </section>
</div>
@endsection