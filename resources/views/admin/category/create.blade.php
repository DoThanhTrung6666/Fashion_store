@extends('layout.admin')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Thêm mới danh mục <a href="{{ route('categories.index') }}" class="btn btn-primary">Danh sách danh mục</a>
        </h1>
    </section>
    <section class="content">
        <div class="row container-fluid">
            <div class="col-md-11">
                <div class="box box-primary">
                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label for="id">ID</label>
                                <input type="text" class="form-control" placeholder="" disabled>
                            </div>
                            <div class="form-group">
                                <label for="name">Tên danh mục</label>
                                <input type="text" class="form-control" placeholder="Nhập tên danh mục" name="name">
                            </div>
                            <div class="form-group">
                                <label for="description">Mô tả</label>
                                <textarea class="form-control" rows="3" placeholder="Nhập nội dung..." name="description"></textarea>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Thêm mới danh mục</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
