@extends('layout.admin')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Danh sách brand
        </h1>
    </section>
    <section class="content">
        <div class="row container-fluid">
            <div class="col-md-11">
                <div class="box box-primary">
                    <table class="table">
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Slug</th>
                            <th scope="col">Description</th>
                            <th scope="col">Logo</th>
                            <th scope="col">Website url</th>
                            <th scope="col">Country</th>
                            <th scope="col">Status</th>
                            <th scope="col">Chức năng</th>
                        </tr>
                            @foreach ($brands as $brand)
                            <tr>
                                <td>{{$brand->name}}</td>
                                <td>{{$brand->slug}}</td>
                                <td>{{$brand->description}}</td>
                                <td><img src="{{asset('storage/' . $brand->logo)}}" width="60" alt=""></td>
                                <td>{{$brand->status}}</td>
                                <td>{{$brand->website_url}}</td>
                                <td>
                                    <form action="{{ route('admin.brands.updateStatus', $brand->id) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" onchange="this.form.submit()">
                                            <option value="1" {{ $brand->status == 1 ? 'selected' : '' }}>Đang kinh doanh</option>
                                            <option value="2" {{ $brand->status == 2 ? 'selected' : '' }}>Ngừng kinh doanh</option>
                                        </select>
                                    </form>
                                </td>
                                <td>{{$brand->country}}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{route('brands.edit', $brand)}}" class="btn btn-success">Edit</a>
                                        <form action="{{route('brands.destroy', $brand)}}" method="post">
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
</div>
@endsection
