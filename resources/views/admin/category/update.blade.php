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
              <form role="form" method="post" action="">
              @csrf
                <div class="box-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">id</label>
                    <input type="text" class="form-control" placeholder="" disabled>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Tên danh mục</label>
                    <input type="text" class="form-control" placeholder="Nhập tên danh mục" name="nameCate">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Mô tả</label>
                    <textarea class="form-control" rows="3" placeholder="Nhập nội dung..." name="desc"></textarea>
                  </div>
                </div>
                <div class="box-footer">
                  <button type="submit" name="" class="btn btn-primary">Sửa danh mục</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </section>
    </div>
@endsection
