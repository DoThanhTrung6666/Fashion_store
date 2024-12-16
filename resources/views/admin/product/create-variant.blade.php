@extends('layout.admin')

@section('content')
<div class="content-wrapper">
    <section class="content-header" style="margin-bottom: 10px">
        <h1>Thêm biến thể cho sản phẩm: {{ $product->name }}</h1>
    </section>
    @if($errors->any())
        <span style="color: red">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </span>
    @endif
    <section class="content">
        <div class="row container-fluid">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <form action="{{ route('admin.products.variants.store', $product->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="product_id" value="{{$product->id}}">
                            <div class="form-group">
                                <label for="color_id">Màu sắc</label>
                                <select name="variant[0][color_id]" class="form-control">
                                    <option value="">Chọn màu sắc</option>
                                    @foreach($colors as $color)
                                        <option value="{{ $color->id }}">{{ $color->name }}</option>
                                    @endforeach
                                </select>
                                @error('variant.0.color_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="size_id">Kích thước</label>
                                <select name="variant[0][size_id]" class="form-control">
                                    <option value="">Chọn kích thước</option>
                                    @foreach($sizes as $size)
                                        <option value="{{ $size->id }}">{{ $size->name }}</option>
                                    @endforeach
                                </select>
                                @error('variant.0.size_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="stock_quantity">Số lượng tồn kho</label>
                                <input type="number" name="variant[0][stock_quantity]" class="form-control" min="1">
                                @error('variant.0.stock_quantity')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="image_variant">Ảnh biến thể</label>
                                <input type="file" name="variant[0][image_variant]" class="form-control">
                                @error('variant.0.image_variant')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-success">Thêm biến thể</button>
                            <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-secondary">Quay lại</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
