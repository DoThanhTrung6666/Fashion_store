@extends('layout.admin')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Chỉnh sửa sản phẩm <a href="{{ route('admin.products.index') }}" class="btn btn-primary">Danh sách sản phẩm</a>
        </h1>
    </section>
    <section class="content">
        <div class="row container-fluid">
            <div class="col-md-11">
                <div class="box box-primary">
                    <form role="form" method="post" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="box-body">
                            <div class="form-group">
                                <label for="">ID sản phẩm</label>
                                <input type="text" class="form-control" value="{{ $product->id }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="">Tên sản phẩm</label>
                                <input type="text" class="form-control" placeholder="Nhập tên sản phẩm" name="name" value="{{ $product->name }}">
                            </div>
                            <div class="form-group">
                                <label for="">Ảnh sản phẩm</label>
                                <input type="file" class="form-control" name="image">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" width="100">
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="">Giá chung</label>
                                <input type="number" class="form-control" placeholder="Nhập giá sản phẩm" name="price" value="{{ $product->price }}">
                            </div>
                            <div class="form-group">
                                <label for="">Giá sau khi giảm</label>
                                <input type="text" class="form-control" placeholder="Nhập giá giảm" name="discount" value="{{ $product->discount }}">
                            </div>
                            <div class="form-group">
                                <label for="">Số lượng</label>
                                <input type="text" class="form-control" placeholder="Nhập số lượng" name="stock_quantity" value="{{ $product->stock_quantity }}">
                            </div>
                            <div class="form-group">
                                <label for="">Thương hiệu</label>
                                <select class="form-control" name="brand_id">
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ $brand->id == $product->brand_id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Danh mục sản phẩm</label>
                                <select class="form-control" name="category_id">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Mô tả</label>
                                <textarea class="form-control" rows="3" placeholder="Nhập nội dung..." name="description">{{ $product->description }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="status">Trạng thái sản phẩm</label>
                                <div class="status-options">
                                    <label class="status-option">
                                        <input type="radio" name="status" value="1" {{ $product->status == 'active' ? 'checked' : '' }}>
                                        <span>Đang bán</span>
                                    </label>
                                    <label class="status-option">
                                        <input type="radio" name="status" value="0" {{ $product->status == 'inactive' ? 'checked' : '' }}>
                                        <span>Ngừng kinh doanh</span>
                                    </label>
                                </div>
                            </div>

                            <h3>Biến thể sản phẩm</h3>
                            <div id="variants">
                                @foreach($product->variants as $index => $variant)
                                    <div class="variant-group">
                                        <input type="hidden" name="variant[{{ $index }}][id]" value="{{ $variant->id }}">
                                        <div class="form-group">
                                            <label for="variant[{{ $index }}][color_id]">Màu sắc</label>
                                            <select name="variant[{{ $index }}][color_id]" class="form-control">
                                                @foreach($colors as $color)
                                                    <option value="{{ $color->id }}" {{ $color->id == $variant->color_id ? 'selected' : '' }}>{{ $color->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="variant[{{ $index }}][size_id]">Kích thước</label>
                                            <select name="variant[{{ $index }}][size_id]" class="form-control">
                                                @foreach($sizes as $size)
                                                    <option value="{{ $size->id }}" {{ $size->id == $variant->size_id ? 'selected' : '' }}>{{ $size->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="variant[{{ $index }}][price]">Giá biến thể</label>
                                            <input type="text" name="variant[{{ $index }}][price]" class="form-control" value="{{ $variant->price }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="variant[{{ $index }}][stock_quantity]">Số lượng tồn kho</label>
                                            <input type="text" name="variant[{{ $index }}][stock_quantity]" class="form-control" value="{{ $variant->stock_quantity }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" id="addVariantBtn" class="btn btn-secondary">Thêm biến thể</button><br>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Cập nhật sản phẩm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    let variantIndex = {{ $product->variants->count() }};

    function addVariant() {
        let variantsDiv = document.getElementById('variants');
        let newVariant = `
            <div class="variant-group">
                <div class="form-group">
                    <label for="variant[${variantIndex}][color_id]">Màu sắc</label>
                    <select name="variant[${variantIndex}][color_id]" class="form-control">
                        @foreach($colors as $color)
                            <option value="{{ $color->id }}">{{ $color->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="variant[${variantIndex}][size_id]">Kích thước</label>
                    <select name="variant[${variantIndex}][size_id]" class="form-control">
                        @foreach($sizes as $size)
                            <option value="{{ $size->id }}">{{ $size->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="variant[${variantIndex}][price]">Giá biến thể</label>
                    <input type="text" name="variant[${variantIndex}][price]" class="form-control">
                </div>
                <div class="form-group">
                    <label for="variant[${variantIndex}][stock_quantity]">Số lượng tồn kho</label>
                    <input type="text" name="variant[${variantIndex}][stock_quantity]" class="form-control">
                </div>
            </div>
        `;
        variantsDiv.insertAdjacentHTML('beforeend', newVariant);
        variantIndex++;
    }

    document.getElementById('addVariantBtn').addEventListener('click', addVariant);
</script>

@endsection
