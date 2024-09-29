@extends('layouts.admin')

@section('content')
    <h1>Create New Banner</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}">
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="image">Banner Image</label>
            <input type="file" name="image" id="image" class="form-control-file">
        </div>

        <div class="form-group form-check">
            <input type="checkbox" name="is_active" id="is_active" class="form-check-input" {{ old('is_active') ? 'checked' : '' }}>
            <label for="is_active" class="form-check-label">Active</label>
        </div>

        <button type="submit" class="btn btn-primary">Create</button>
    </form>
@endsection
