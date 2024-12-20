@extends('layout.admin')

@section('content')
<div class="content-wrapper">
      <section class="content-header">
        <h1>
          Sửa danh mục <a href="" class="btn btn-primary">Danh sách danh mục</a>
        </h1>
      </section>
      <section class="content">
        <div class="row container-fluid">
          <div class="col-md-11">
            <div class="box box-primary">
              <form role="form" method="post" action="{{route('admin.categories.update', $category)}}" enctype="multipart/form-data">
              @csrf
              @method('PUT')
                <div class="box-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Tên danh mục</label>
                    <input type="text" class="form-control" placeholder="Nhập tên cate" name="name" value="{{$category->name}}">
                  </div>
                </div>
                <div class="box-footer">
                  <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </section>
    </div>
@endsection