
@extends('layout.admin')

@section('content')
<div class="content-wrapper">
      <section class="content-header">
        <h1>
          Thêm mới sản phẩm <a href="" class="btn btn-primary">Danh sách sản phẩm</a>
        </h1>
      </section>
      <section class="content">

        <div class="row container-fluid">
          <div class="col-md-11">
            <div class="box box-primary">
              <form role="form" method="post" action="{{ route('products.store')}}" enctype="multipart/form-data">
              @csrf
                <div class="box-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">id</label>
                    <input type="text" class="form-control" placeholder="" disabled>
                  </div>
            {{-- Tên sản phẩm  --}}
                  <div class="form-group">
                    <label for="">Tên sản phẩm</label>
                    <input type="text" class="form-control" placeholder="Nhập tên sản phẩm" name="name">
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
            {{-- Ảnh sản phẩm  --}}
                  <div class="form-group">
                    <label for="">Ảnh sản phẩm</label>
                    <input type="file" class="form-control" placeholder="" name="image">
                    @error('image')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="">Giá sản phẩm</label>
                    <input type="number" class="form-control" placeholder="Nhập giá sản phẩm" name="price">
                    @error('price')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                  {{-- <div class="form-group">
                    <label for="">Giá sau khi giảm</label>
                    <input type="text" class="form-control" placeholder="Nhập tên sản phẩm" name="discount">
                    @error('discount')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div> --}}
                  {{-- <div class="form-group">
                    <label for="">Số lượng</label>
                    <input type="text" class="form-control" placeholder="Nhập tên sản phẩm" name="stock_quantity">
                    @error('stock_quantity')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div> --}}
                  <div class="form-group">
                    <label for="">Thương hiệu</label>
                    <select class="form-control" name="brand_id">
                        @foreach ($brands as $item )
                            <option value="{{$item->id}}">{{$item->name}}</option>
                            {{-- <option value="1">Trung con</option> --}}
                        @endforeach
                    </select>
                    @error('brand_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="">Danh mục sản phẩm</label>
                    <select class="form-control" name="category_id">
                        @foreach ($categorys as $item )
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="">Mô tả</label>
                    <textarea class="form-control" rows="3" placeholder="Nhập nội dung..." name="description"></textarea>
                    @error('description')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                {{-- <div class="form-group">
                    <label for="status">Trạng thái sản phẩm</label>
                    <div class="status-options">
                        <label class="status-option">
                            <input type="radio" name="status" value="1" checked>
                            <span>Đang bán</span>
                        </label>
                        <label class="status-option">
                            <input type="radio" name="status" value="0">
                            <span>Ngừng kinh doanh</span>
                        </label>
                    </div>
                    @error('status')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div> --}}



                <!-- Biến thể sản phẩm -->
        <h3>Biến thể sản phẩm</h3>
        <div id="variants">
            <!-- Duyệt qua các biến thể đã thêm -->
            @foreach(old('variant', []) as $index => $variant)
                <div class="variant-group">
                    {{-- <div class="form-group">
                        <label for="variant[{{ $index }}][color_id]">Màu sắc</label>
                        <div class="color-options">
                            @foreach($colors as $color)
                                <label class="color-radio" style="background-color: {{ $color->name }};">
                                    <input type="radio" name="variant[{{ $index }}][color_id]" value="{{ $color->id }}"
                                        @if(old('variant.' . $index . '.color_id') == $color->id) checked @endif
                                    >
                                </label>
                            @endforeach
                        </div>
                        @error('variant.' . $index . '.color_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div> --}}

                    <div class="form-group">
                        <label for="variant[{{ $index }}][color_id]">Màu sắc</label>
                        <select name="variant[{{ $index }}][color_id]" class="form-control" id="variant[{{ $index }}][color_id]">
                            <option value="">Chọn màu sắc</option> <!-- Tùy chọn mặc định -->
                            @foreach($colors as $color)
                                <option value="{{ $color->id }}"
                                    @if(old('variant.' . $index . '.color_id') == $color->id) selected @endif
                                >
                                    {{ $color->name }} <!-- Hiển thị tên màu -->
                                </option>
                            @endforeach
                        </select>
                        @error('variant.' . $index . '.color_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>


                    {{-- <div class="form-group">
                        <label for="variant[{{ $index }}][size_id]">Kích thước</label>
                        <div class="size-options">
                            @foreach($sizes as $size)
                                <label class="size-option">
                                    <input type="radio" name="variant[{{ $index }}][size_id]" value="{{ $size->id }}"
                                        @if(old('variant.' . $index . '.size_id') == $size->id) checked @endif
                                    >
                                    <span>{{ $size->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('variant.' . $index . '.size_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div> --}}
                    <div class="form-group">
                        <label for="variant[{{ $index }}][size_id]">Kích thước</label>
                        <select name="variant[{{ $index }}][size_id]" class="form-control" id="variant[{{ $index }}][size_id]">
                            <option value="">Chọn kích thước</option> <!-- Thêm một tùy chọn mặc định -->
                            @foreach($sizes as $size)
                                <option value="{{ $size->id }}"
                                    @if(old('variant.' . $index . '.size_id') == $size->id) selected @endif
                                >
                                    {{ $size->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('variant.' . $index . '.size_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>


                    {{-- <div class="form-group">
                        <label for="variant[{{ $index }}][price]">Giá biến thể</label>
                        <input type="text" name="variant[{{ $index }}][price]" class="form-control" value="{{ old('variant.' . $index . '.price') }}">
                        @error('variant.' . $index . '.price')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div> --}}

                    <div class="form-group">
                        <label for="variant[{{ $index }}][stock_quantity]">Số lượng tồn kho</label>
                        <input type="text" name="variant[{{ $index }}][stock_quantity]" class="form-control" value="{{ old('variant.' . $index . '.stock_quantity') }}">
                        @error('variant.' . $index . '.stock_quantity')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="variant[{{ $index }}][image_variant]">Ảnh biến thể sản phẩm</label>
                        <input type="file" name="variant[{{ $index }}][image_variant]" class="form-control" value="{{ old('variant.' . $index . '.image_variant') }}">
                        @error('variant.' . $index . '.image_variant')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            @endforeach

            <button type="button" id="addVariantBtn" class="btn btn-secondary">Thêm biến thể</button><br>
        </div>
                <div class="box-footer">
                  <button type="submit" name="createProduct" class="btn btn-primary">Thêm mới sản phẩm</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </section>
    </div>


    {{-- Xử lí thêm nhiều biến thể mới  --}}

    <script>
        let variantIndex = 1; // Để đánh dấu các biến thể (sử dụng biến đếm)

function addVariant(existingVariant = {}) {
    let variantsDiv = document.getElementById('variants');
    let index = variantIndex; // Tạo chỉ số cho biến thể mới

    // HTML cho biến thể mới
    let newVariant = `
        <div class="variant-group" id="variant-group-${index}">
            <div class="form-group">
                <label for="variant[${index}][color_id]">Màu sắc</label>
                <select name="variant[${index}][color_id]" class="form-control" id="variant[${index}][color_id]">
                    <option value="">Chọn màu sắc</option> <!-- Tùy chọn mặc định -->
                    @foreach($colors as $color)
                        <option value="{{ $color->id }}"
                            ${existingVariant.color_id == {{ $color->id }} ? 'selected' : '' }>
                            {{ $color->name }} <!-- Hiển thị tên màu -->
                        </option>
                    @endforeach
                </select>
                @error('variant.${index}.color_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="variant[${index}][size_id]">Kích thước</label>
                <select name="variant[${index}][size_id]" class="form-control">
                    @foreach($sizes as $size)
                        <option value="{{ $size->id }}"
                            ${existingVariant.size_id == {{ $size->id }} ? 'selected' : ''}>{{ $size->name }}</option>
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
                <input type="file" name="variant[${index}][image_variant]" class="form-control"
                    value="${existingVariant.image_variant || ''}">
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
    saveVariantsToStorage();
}

// Lưu tất cả các biến thể vào localStorage
function saveVariantsToStorage() {
    let variants = [];
    let variantGroups = document.querySelectorAll('.variant-group');

    variantGroups.forEach((group, index) => {
        let color_id = group.querySelector('[name="variant[' + index + '][color_id]"]:checked')?.value || '';
        let size_id = group.querySelector('[name="variant[' + index + '][size_id]"]').value || '';
        let price = group.querySelector('[name="variant[' + index + '][price]"]').value || '';
        let stock_quantity = group.querySelector('[name="variant[' + index + '][stock_quantity]"]').value || '';
        // let image_variant = group.querySelector('[name="variant[' + index + '][image_variant]"]').value || '';

        let image_variant = group.querySelector('[name="variant[' + index + '][image_variant]"]').files[0]; // Lấy file ảnh

        let image_url = ''; // Tạo biến để lưu URL ảnh

        // Nếu có ảnh được chọn, bạn có thể tạo URL đối tượng cho ảnh
        if (image_variant) {
            image_url = URL.createObjectURL(image_variant); // Tạo URL cho ảnh
        } else if (existingVariant.image_variant) {
            image_url = existingVariant.image_variant; // Sử dụng ảnh cũ nếu có
        }

        variants.push({
            color_id,
            size_id,
            price,
            stock_quantity,
            // image_variant
            image_variant: image_url
        });
    });

    localStorage.setItem("variants", JSON.stringify(variants));
}

document.getElementById('addVariantBtn').addEventListener('click', function() {
    addVariant();
});

    </script>

    {{-- <button type="button" id="addVariantBtn" class="btn btn-secondary">Thêm biến thể</button> --}}

@endsection
