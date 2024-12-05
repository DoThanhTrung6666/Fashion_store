@extends('layout.admin')

@section('content')



    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Chỉnh sửa banner
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


                        <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Title</label>
                                    <input type="text" class="form-control" name="title" id="title"
                                        value="{{ old('title', $banner->title) }}">
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" rows="3" name="description" id="description">{{ old('description', $banner->description) }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Image</label>
                                    <input type="file" name="image_path" id="image">
                                    <br>
                                    <img src="{{ asset('storage/' . $banner->image_path) }}" alt="{{ $banner->title }}" width="100">
                                </div>
                                
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Link</label>
                                    <input type="url" class="form-control" placeholder="Link..." name="link"
                                        id="link" value="{{ old('link', $banner->link) }}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Position</label>
                                    <input type="number" class="form-control" name="position" id="position"
                                        value="{{ old('position', $banner->position, 0) }}">
                                </div>
                                <div class="form-group">
                                    <label for="start_date">Start Date</label>
                                    <input type="datetime-local" class="form-control" name="start_date" id="start_date"
                                        value="{{ old('start_date', $banner->start_date) }}">
                                </div>
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <input type="datetime-local" class="form-control" name="end_date" id="end_date"
                                        value="{{ old('end_date', $banner->end_date) }}">
                                </div>
                                <div class="form-group">
                                    <label for="is_active">Is Active</label>
                                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input"
                                        {{ old('is_active', $banner->is_active) ? 'checked' : '' }}>
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
