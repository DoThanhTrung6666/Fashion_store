
@extends('layout.admin')

@section('content')
<div class="content-wrapper">
      <section class="content-header">
        <h1>
          Thêm mới sản phẩm <a href="" class="btn btn-primary">Danh sách sản phẩm</a>
        </h1>
      </section>
      <section class="content">

        <div class="row container-fluid">
          <div class="col-md-11">
            <div class="box box-primary">
              <form role="form" method="post" action="{{ route('sizes.store')}}" enctype="multipart/form-data">
              @csrf
                <div class="box-body">
                  <div class="form-group">
                    <label for="">id</label>
                    <input type="text" class="form-control" placeholder="" disabled>
                  </div>
                  <div class="form-group">
                    <label for="">Tên size</label>
                    <input type="text" class="form-control" placeholder="Nhập tên size" name="name">
                  </div>
                <div class="box-footer">
                  <button type="submit" name="createSize" class="btn btn-primary">Thêm mới size</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </section>
    </div>


    

    {{-- <button type="button" id="addVariantBtn" class="btn btn-secondary">Thêm biến thể</button> --}}

@endsection
