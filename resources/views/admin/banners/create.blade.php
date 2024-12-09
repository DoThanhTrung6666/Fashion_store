@extends('layout.admin')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Thêm mới banner
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
                        <form role= "form" action="{{ route('admin.banners.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tiêu đề</label>
                                    <input type="text" class="form-control" placeholder="Tiêu đề..." name="title"
                                        id="title" value="{{ old('title') }}">
                                </div>
                                <div class="form-group">
                                    <label for="description">Mô tả</label>
                                    <textarea class="form-control" rows="3" placeholder="Nôị dung..." name="description" id="description">{{ old('description') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Ảnh</label>
                                    <input type="file" name="image_path" id="image">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Đường dẫn</label>
                                    <input type="url" class="form-control" placeholder="Link..." name="link"
                                        id="link" value="{{ old('link') }}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Vị trí</label>
                                    <input type="number" class="form-control" name="position" id="position"
                                        value="{{ old('position', 0) }}">
                                </div>
                                <div class="form-group">
                                    <label for="start_date">Ngày bắt đầu</label>
                                    <input type="datetime-local" class="form-control" name="start_date" id="start_date"
                                        value="{{ old('start_date') }}">
                                </div>
                                <div class="form-group">
                                    <label for="end_date">Ngày kết thúc</label>
                                    <input type="datetime-local" class="form-control" name="end_date" id="end_date"
                                        value="{{ old('end_date') }}">
                                </div>
                                <div class="form-group">
                                    <label for="is_active" class="form-check-label">Trạng thái hoạt động</label>
                                    <input type="checkbox" name="is_active" id="is_active" value="1"
                                        {{ old('is_active', true) ? 'checked' : '' }}>

                                </div>
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary">Thêm mới banner</button>
                                </div>
                           
                    </form>



                </div>
            </div>
    </div>
    </section>
    </div>
    </div>

@endsection
