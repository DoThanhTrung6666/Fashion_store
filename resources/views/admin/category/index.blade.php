@extends('layout.admin')

@section('content')

<div class="content-wrapper">
            <section class="content-header">
                <h1>
                    Danh sách danh mục
                </h1>
                <a class="btn btn-primary" href="{{ route('admin.categories.create') }}">Thêm mới danh mục</a>
            </section>
            <section class="content">
                <div class="row container-fluid">
                    <div class="col-md-12">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="box box-primary">

                            <table class="table">
                                <tr>
                                    <th style="text-align: center" scope="col" style=""></th>
                                    <th style="text-align: center" scope="col" style="">STT</th>
                                    <th style="text-align: center" scope="col" style="">Tên danh mục</th>
                                    <th style="text-align: center" scope="col" style="">Mô tả</th>
                                    <th style="text-align: center" scope="col" style="">Ngày tạo</th>
                                    <th style="text-align: center" scope="col" style="">Ngày cập nhật</th>
                                </tr>
                               @foreach ($categories as $category)
                               <tr>
                                <td style="text-align: center"><input type="checkbox"></td>
                                <td style="text-align: center">{{$category->id}}</td>
                                <td style="text-align: center">{{$category->name}}</td>
                                <td style="text-align: center">{{$category->description}}</td>
                                <td style="text-align: center">{{$category->created_at}}</td>
                                <td style="text-align: center">{{$category->updated_at}}</td>
                                <td style="text-align: center">
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning">Sửa</a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này không?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Xóa</button>
                                    </form>

                                </td>
                                </tr>
                               @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
@endsection