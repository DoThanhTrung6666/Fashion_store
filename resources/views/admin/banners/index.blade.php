@extends('layout.admin')

@section('content')
    


    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Danh sách banner <a class="btn btn-primary" href="{{ route('admin.banners.create') }}">Thêm mới Banner</a>
            </h1>
        </section>
        <section class="content">
            <div class="row container-fluid">
                <div class="col-md-12">
                    <div class="box box-primary">
                        @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                        <table class="table">
                            <tr>
                                
                                <th style="text-align: center" scope="col" style="">Tiêu đề</th>
                                <th style="text-align: center" scope="col" style="">Mô tả</th>
                                <th style="text-align: center" scope="col" style="">Ảnh</th>
                                <th style="text-align: center" scope="col" style="">Vị trí</th>
                                <th style="text-align: center" scope="col" style="">Trạng thái hoạt động</th>
                                <th style="text-align: center" scope="col" style="">Hành động</th>

                            </tr>

                            @foreach ($banners as $banner)
                                <tr style="text-align: center">
                                    
                                    <td>{{ $banner->title }}</td>
                                    <td>{{ $banner->description }}</td>
                                    <td><img src="{{ asset('storage/' . $banner->image_path) }}"
                                            alt="{{ $banner->title }}" width="100" height="100"></td>
                                    <td>{{ $banner->position }}</td>
                                    <td>{{ $banner->is_active ? 'Yes' : 'No' }}</td>
                                    <td>
                                        <a href="{{ route('admin.banners.edit', $banner->id) }}" class="btn btn-warning">Sửa</a>
                                        <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            {{-- <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('ban co chac muon xoa khong?')">Xóa</button> --}}
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
