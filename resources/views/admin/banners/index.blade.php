@extends('layout.admin')

@section('content')
    

    @if (session('success'))
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

    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Danh sách banner <a class="btn btn-primary" href="{{ route('banners.create') }}">Thêm mới Banner</a>
            </h1>
        </section>
        <section class="content">
            <div class="row container-fluid">
                <div class="col-md-12">
                    <div class="box box-primary">

                        <table class="table">
                            <tr>
                                <th style="text-align: center" scope="col" style=""></th>
                                <th style="text-align: center" scope="col" style="">Title</th>
                                <th style="text-align: center" scope="col" style="">Description</th>
                                <th style="text-align: center" scope="col" style="">Image</th>
                                <th style="text-align: center" scope="col" style="">Position</th>
                                <th style="text-align: center" scope="col" style="">Active</th>
                                <th style="text-align: center" scope="col" style="">Actions</th>
                                
                            </tr>

                           @foreach ($banners as $banner)
                                
                                        <tr style="text-align: center">
                                            <td><input type="checkbox"></td>
                                            <td>{{$banner->title}}</td>
                                            <td>{{$banner->description}}</td>
                                            <td><img src="{{ asset('storage/' . $banner->image_path) }}" alt="{{ $banner->title }}"
                                                width="100" height="100"></td>
                                            <td>{{$banner->position}}</td>
                                            <td>{{ $banner->is_active ? 'Yes' : 'No' }}</td>
                                            <td>
                                                <a href="{{ route('banners.edit', $banner->id) }}" class="btn btn-warning">Sửa</a>
                                                <form action="{{ route('banners.destroy', $banner->id) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('ban co chac muon xoa khong?')">Xóa</button>
                                                </form></td>
                                        </tr>
                               

                           @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>


@endsection
