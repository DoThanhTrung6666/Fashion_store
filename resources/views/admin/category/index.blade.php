@extends('layout.admin')
@section('content')
    <section class="content-header">
        <h1>
            Danh sách danh mục
        </h1>
    </section>
    <section class="content">
        <div class="row container-fluid">
            <div class="col-md-11">
                <div class="box box-primary">
                    <table class="table">
                        <tr>
                            <th scope="col" class="col-1"></th>
                            <th scope="col" class="col-3">Tên:</th>
                            <th scope="col" class="col-4">Mô tả:</th>
                            <th scope="col" class="col-2">Thời gian thêm:</th>
                            <th scope="col" class="col-2">Thời gian sửa:</th>
                            <th scope="col" class="col-2">Thao tác</th>
                        </tr>

                        @foreach ($categories as $cate)
                            <tr>
                                <td>{{ $loop->iteration }}</td> <!-- Sử dụng $loop->iteration để tạo số thứ tự -->
                                <td>{{$cate->name}}</td>
                                <td>{{$cate->description}}</td>
                                <td>{{$cate->created_at}}</td>
                                <td>{{$cate->updated_at}}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{route('admin.categories.edit', $cate)}}" class="btn btn-success">Edit</a>
                                        <form action="{{route('admin.categories.destroy', $cate)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Bạn muốn xóa không?')" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach

                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
