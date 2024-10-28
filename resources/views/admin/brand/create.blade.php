@extends('layout.admin')

@section('content')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Thêm mới brand
            </h1>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>
            @endif

        </section>
        <section class="content">
            <div class="row container-fluid">
                <div class="col-md-11">
                    <div class="box box-primary">
                        <form role="form" method="post" action="{{ route('admin.brands.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Name</label>
                                    <input type="text" class="form-control" placeholder="Nhập tên brand" name="name">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Logo</label>
                                    <input type="file" class="form-control" name="logo">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Description</label>
                                    <textarea class="form-control" rows="3" placeholder="Nhập nội dung..." name="description"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Country</label>
                                    <input type="text" class="form-control" placeholder="Nhập địa chỉ" name="country">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Website url</label>
                                    <input type="text" class="form-control" placeholder="Nhập địa chỉ url"
                                        name="website_url">
                                </div>
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Thêm mới brand</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

          </div>
        </div>
      </section>
    </div>
  </div>

        </section>
    </div>
    </div>

@endsection
