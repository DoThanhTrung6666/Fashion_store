@extends('layout.admin')

@section('content')
    <div class="content-wrapper">
        <section class="content-header clearfix">
            <h1 class="pull-left">
                Thêm mới danh mục
            </h1>

        </section>
        <section class="content">
            <div class="row container-fluid">
                <div class="col-md-11">
                    <div class="box box-primary">
                        <form action="{{ route('admin.categories.store') }}" method="POST">
                            @csrf
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="id">ID</label>
                                    <input type="text" class="form-control" placeholder="" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="name">Tên danh mục</label>
                                    <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" placeholder="Nhập tên danh mục"
                                        name="name">
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Thêm mới danh mục</button>
                                <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">Danh sách danh
                                    mục</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
