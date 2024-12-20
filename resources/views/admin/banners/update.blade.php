@extends('layout.admin')

@section('content')



    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Chỉnh sửa banner
            </h1>
            
        </section>

        <section class="content">
            <div class="row container-fluid">
                <div class="col-md-11">
                    <div class="box box-primary">


                        <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tiêu đề</label>
                                    <input type="text" class="form-control" name="title" id="title"
                                        value="{{ old('title', $banner->title) }}">
                                        @error('title')
                                        <span style="color:red">{{ $message }} </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="description">Mô tả</label>
                                    <textarea class="form-control" rows="3" name="description" id="description">{{ old('description', $banner->description) }}</textarea>
                                    @error('description')
                                    <span style="color:red">{{ $message }} </span>
                                @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Ảnh</label>
                                    <input type="file" name="image_path" id="image">
                                    @error('image_path')
                                    <span style="color:red">{{ $message }} </span>
                                @enderror
                                    <br>
                                    <img src="{{ asset('storage/' . $banner->image_path) }}" alt="{{ $banner->title }}" width="100">
                                </div>
                                
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Đường dẫn</label>
                                    <input type="url" class="form-control" placeholder="Link..." name="link"
                                        id="link" value="{{ old('link', $banner->link) }}">
                                        @error('link')
                                        <span style="color:red">{{ $message }} </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Vị trí</label>
                                    <input type="number" class="form-control" name="position" id="position"
                                        value="{{ old('position', $banner->position, 0) }}">
                                        @error('position')
                                        <span style="color:red">{{ $message }} </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="start_date">Ngày bắt đầu</label>
                                    <input type="datetime-local" class="form-control" name="start_date" id="start_date"
                                        value="{{ old('start_date', $banner->start_date) }}">
                                        @error('start_date')
                                        <span style="color:red">{{ $message }} </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="end_date">Ngày kết thúc</label>
                                    <input type="datetime-local" class="form-control" name="end_date" id="end_date"
                                        value="{{ old('end_date', $banner->end_date) }}">
                                        @error('end_date')
                                        <span style="color:red">{{ $message }} </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="is_active">Trạng thái hoạt động</label>
                                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input"
                                        {{ old('is_active', $banner->is_active) ? 'checked' : '' }}>
                                        @error('is_active')
                                        <span style="color:red">{{ $message }} </span>
                                    @enderror
                                </div>
                                
                                
                                
                                </div>
                                <div class="box-footer">
                                  <button type="submit" class="btn btn-primary">Cập nhật banner</button>
                                </div></form>


                    </div>
                </div>
            </div>
        </section>
    </div>


@endsection
