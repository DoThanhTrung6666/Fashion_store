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
              <form role="form" method="post" action="{{route('brands.update', $brand)}}" enctype="multipart/form-data">
              @csrf
              @method('PUT')
                <div class="box-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" class="form-control" placeholder="Nhập tên brand" name="name" value="{{$brand->name}}">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Logo</label>
                    <input type="file" class="form-control" name="logo">
                    <img src="{{asset('storage/'.$brand->logo)}}" width="60" alt="">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Description</label>
                    <textarea class="form-control" rows="3" placeholder="Nhập nội dung..." name="description">{{$brand->name}}</textarea>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Country</label>
                    <input type="text" class="form-control" placeholder="Nhập địa chỉ" name="country" value="{{$brand->country}}">
                  </div>
                </div>
                <div class="box-footer">
                  <button type="submit" class="btn btn-primary">Update brand</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </section>
    </div>
@endsection
