@extends('layout.admin')

@section('content')
    <h1>Banners List</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif



    <section class="content-header">
        <h1>
            Danh sách banner
        </h1>
    </section>
    <div class="mb-6">
        <a href="{{ route('banners.create') }}" class="btn btn-primary">Create New Banner</a>
    </div>
    <section class="content">

        <div class="row container-fluid">
            <div class="col-md-11">
                <div class="box box-primary">



                    <table class="table">
                        <tr>

                            <th scope="col" class="col-3">Title</th>
                            <th scope="col" class="col-4">Description</th>
                            <th scope="col" class="col-2">Image</th>
                            <th scope="col" class="col-2">Position</th>
                            <th scope="col" class="col-2">Active</th>
                            <th scope="col" class="col-2">Actions</th>
                        </tr>
                        @foreach($banners as $banner)
                        <tr>
                            <td>{{ $banner->title }}</td>
                            <td>{{ $banner->description }}</td>
                            <td>
                                <img src="{{ asset('storage/' . $banner->image_path) }}" alt="{{ $banner->title }}" width="100">
                            </td>
                            <td>{{ $banner->position }}</td>
                            <td>{{ $banner->is_active ? 'Yes' : 'No' }}</td>
                            <td>
                                <a href="{{ route('admin.banners.edit', $banner->id) }}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('ban co chac muon xoa khong?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </table>
                </div>
            </div>
        </div>
    </section>

@endsection
