@extends('layouts.admin')

@section('content')
    <h1>Banners List</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">Create New Banner</a>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Image</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($banners as $banner)
                <tr>
                    <td>{{ $banner->title }}</td>
                    <td>{{ $banner->description }}</td>
                    <td>
                        <img src="{{ asset('storage/' . $banner->image_path) }}" alt="{{ $banner->title }}" width="100">
                    </td>
                    <td>{{ $banner->is_active ? 'Yes' : 'No' }}</td>
                    <td>
                        <a href="{{ route('admin.banners.edit', $banner->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
