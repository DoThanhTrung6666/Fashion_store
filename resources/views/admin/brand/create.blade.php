@extends('layout.admin')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Thêm mới brand
            </h1>
        </section>
        <section class="content">
            <div class="row container-fluid">
                <div class="col-md-11">
                    <div class="box box-primary">
                        {{-- <form role="form" method="post" action="{{ route('admin.brands.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Name</label>
                                    <input type="text" class="form-control" placeholder="Nhập tên brand" name="name">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Logo</label>
                                    <input type="file" class="form-control" name="logo">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Description</label>
                                    <textarea class="form-control" rows="3" placeholder="Nhập nội dung..." name="description"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Country</label>
                                    <input type="text" class="form-control" placeholder="Nhập địa chỉ" name="country">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Website url</label>
                                    <input type="text" class="form-control" placeholder="Nhập địa chỉ url"
                                        name="website_url">
                                </div>
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Thêm mới brand</button>
                            </div>
                        </form> --}}
                        <form role="form" method="post" action="{{ route('admin.brands.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="box-body">
                                <!-- Name Field -->
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Nhập tên brand" name="name" value="{{ old('name') }}">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Logo Field -->
                                <div class="form-group">
                                    <label for="logo">Logo</label>
                                    <input type="file" class="form-control @error('logo') is-invalid @enderror"
                                        name="logo">
                                    @error('logo')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Description Field -->
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" rows="3" placeholder="Nhập nội dung..."
                                        name="description">{{ old('description') }}</textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Country Field -->
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <input type="text" class="form-control @error('country') is-invalid @enderror"
                                        placeholder="Nhập địa chỉ" name="country" value="{{ old('country') }}">
                                    @error('country')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Website URL Field -->
                                <div class="form-group">
                                    <label for="website_url">Website URL</label>
                                    <input type="text" class="form-control @error('website_url') is-invalid @enderror"
                                        placeholder="Nhập địa chỉ URL" name="website_url" value="{{ old('website_url') }}">
                                    @error('website_url')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Thêm mới brand</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        @endsection
