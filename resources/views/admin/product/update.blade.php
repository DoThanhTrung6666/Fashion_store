@extends('layout.admin')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Sửa sản phẩm <a href="{{ route('admin.products.index') }}" class="btn btn-primary">Danh sách sản phẩm</a>
        </h1>
    </section>
    <section class="content">
        <div class="row container-fluid">
            <div class="col-md-11">
                <div class="box box-primary">
                    <form role="form" method="post" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- Sử dụng PUT để cập nhật -->
                        <div class="box-body">
                            <!-- Tên sản phẩm -->
                            <div class="form-group">
                                <label for="">Tên sản phẩm</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name', $product->name) }}">
                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Ảnh sản phẩm -->
                            <div class="form-group">
                                <label for="">Ảnh sản phẩm</label>
                                <input type="file" class="form-control" name="image">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="Ảnh sản phẩm" class="img-thumbnail" style="max-width: 200px;">
                                @endif
                                @error('image')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Giá sản phẩm -->
                            <div class="form-group">
                                <label for="">Giá sản phẩm</label>
                                <input type="number" class="form-control" name="price" value="{{ old('price', $product->price) }}">
                                @error('price')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Thương hiệu -->
                            <div class="form-group">
                                <label for="">Thương hiệu</label>
                                <select class="form-control" name="brand_id">
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('brand_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Danh mục sản phẩm -->
                            <div class="form-group">
                                <label for="">Danh mục sản phẩm</label>
                                <select class="form-control" name="category_id">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Mô tả -->
                            <div class="form-group">
                                <label for="">Mô tả</label>
                                <textarea class="form-control" rows="3" name="description">{{ old('description', $product->description) }}</textarea>
                                @error('description')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <!-- Biến thể sản phẩm -->
                            <h3>Biến thể sản phẩm</h3>
                            <div id="variants">
                                @foreach($product->variants as $index => $variant)
                                    <div class="variant-group" id="variant-group-{{ $index }}">
                                        <input type="hidden" name="variant[{{ $index }}][id]" value="{{ $variant->id }}">
                                        <!-- Màu sắc -->
                                        <div class="form-group">
                                            <label for="variant[{{ $index }}][color_id]">Màu sắc</label>
                                            <select name="variant[{{ $index }}][color_id]" class="form-control">
                                                @foreach($colors as $color)
                                                    <option value="{{ $color->id }}" {{ $variant->color_id == $color->id ? 'selected' : '' }}>
                                                        {{ $color->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Kích thước -->
                                        <div class="form-group">
                                            <label for="variant[{{ $index }}][size_id]">Kích thước</label>
                                            <select name="variant[{{ $index }}][size_id]" class="form-control">
                                                @foreach($sizes as $size)
                                                    <option value="{{ $size->id }}" {{ $variant->size_id == $size->id ? 'selected' : '' }}>
                                                        {{ $size->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Số lượng tồn kho -->
                                        <div class="form-group">
                                            <label for="variant[{{ $index }}][stock_quantity]">Số lượng tồn kho</label>
                                            <input type="number" name="variant[{{ $index }}][stock_quantity]" class="form-control" value="{{ $variant->stock_quantity }}">
                                        </div>

                                        <!-- Ảnh biến thể -->
                                        <div class="form-group">
                                            <label for="variant[{{ $index }}][image_variant]">Ảnh biến thể</label>
                                            <input type="file" name="variant[{{ $index }}][image_variant]" class="form-control">
                                            @if($variant->image_variant)
                                                <img src="{{ asset('storage/' . $variant->image_variant) }}" alt="Ảnh biến thể" class="img-thumbnail" style="max-width: 200px;">
                                            @endif
                                        </div>

                                        <button type="button" class="btn btn-danger" onclick="removeVariant({{ $index }})">Xóa biến thể</button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" id="addVariantBtn" class="btn btn-secondary">Thêm biến thể</button>
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
@endsection
<script>
    // Khởi tạo index cho biến thể
let variantIndex = {{ count($product->variants) }}; // Số biến thể ban đầu

// Hàm thêm biến thể mới
function addVariant(existingVariant = {}) {
    let variantsDiv = document.getElementById('variants');
    let index = variantIndex; // Tạo chỉ số cho biến thể mới

    // HTML cho biến thể mới
    let newVariant = `
        <div class="variant-group" id="variant-group-${index}">
            <input type="hidden" name="variant[${index}][id]" value="${existingVariant.id || ''}">
            <div class="form-group">
                <label for="variant[${index}][color_id]">Màu sắc</label>
                <select name="variant[${index}][color_id]" class="form-control">
                    <option value="">Chọn màu sắc</option>
                    @foreach($colors as $color)
                        <option value="{{ $color->id }}"
                            ${existingVariant.color_id == {{ $color->id }} ? 'selected' : ''}>
                            {{ $color->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="variant[${index}][size_id]">Kích thước</label>
                <select name="variant[${index}][size_id]" class="form-control">
                    <option value="">Chọn kích thước</option>
                    @foreach($sizes as $size)
                        <option value="{{ $size->id }}"
                            ${existingVariant.size_id == {{ $size->id }} ? 'selected' : ''}>
                            {{ $size->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="variant[${index}][stock_quantity]">Số lượng tồn kho</label>
                <input type="text" name="variant[${index}][stock_quantity]" class="form-control"
                    value="${existingVariant.stock_quantity || ''}">
            </div>

            <div class="form-group">
                <label for="variant[${index}][image_variant]">Ảnh biến thể sản phẩm</label>
                <input type="file" name="variant[${index}][image_variant]" class="form-control">
                ${existingVariant.image_variant ? `
                    <div class="existing-image">
                        <img src="${existingVariant.image_variant}" alt="Ảnh biến thể" class="img-thumbnail" style="max-width: 200px;">
                    </div>
                ` : ''}
            </div>

            <button type="button" class="btn btn-danger" onclick="removeVariant(${index})">Xóa biến thể</button>
        </div>
    `;

    // Thêm biến thể mới vào trong form
    variantsDiv.insertAdjacentHTML('beforeend', newVariant);
    variantIndex++; // Tăng chỉ số biến thể tiếp theo
}

// Xóa biến thể
function removeVariant(index) {
    document.getElementById(`variant-group-${index}`).remove();
}

// Thêm biến thể khi nhấn nút
document.getElementById('addVariantBtn').addEventListener('click', function() {
    addVariant();
});

// Load các biến thể hiện tại khi mở form
window.onload = function() {
    @foreach($product->variants as $index => $variant)
        addVariant({
            color_id: {{ $variant->color_id }},
            size_id: {{ $variant->size_id }},
            stock_quantity: {{ $variant->stock_quantity }},
            image_variant: "{{ asset('storage/' . $variant->image) }}"
        });
    @endforeach
};

</script>
