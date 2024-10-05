
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
                  <div class="form-group">
                    <label for="">Tên sản phẩm</label>
                    <input type="text" class="form-control" placeholder="Nhập tên sản phẩm" name="name">
                  </div>
                  <div class="form-group">
                    <label for="">Ảnh sản phẩm</label>
                    <input type="file" class="form-control" placeholder="" name="image">
                  </div>
                  <div class="form-group">
                    <label for="">Giá chung</label>
                    <input type="number" class="form-control" placeholder="Nhập giá sản phẩm" name="price">
                  </div>
                  <div class="form-group">
                    <label for="">Giá sau khi giảm</label>
                    <input type="text" class="form-control" placeholder="Nhập tên sản phẩm" name="discount">
                  </div>
                  <div class="form-group">
                    <label for="">Số lượng</label>
                    <input type="text" class="form-control" placeholder="Nhập tên sản phẩm" name="stock_quantity">
                  </div>
                  <div class="form-group">
                    <label for="">Thương hiệu</label>
                    <select class="form-control" name="brand_id">
                        @foreach ($brands as $item )
                            <option value="{{$item->id}}">{{$item->name}}</option>
                            {{-- <option value="1">Trung con</option> --}}
                        @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="">Danh mục sản phẩm</label>
                    <select class="form-control" name="category_id">
                        @foreach ($categorys as $item )
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="">Mô tả</label>
                    <textarea class="form-control" rows="3" placeholder="Nhập nội dung..." name="description"></textarea>
                  </div>
                  <div class="form-group">
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
                </div>



                    <h3>Biến thể sản phẩm</h3>
                    <div id="variants">
                        <!-- Biến thể đầu tiên -->
                        <div class="variant-group">
                            <div class="form-group">
                                <label for="variant[0][color_id]">Màu sắc</label>
                                <div class="color-options">
                                    @foreach($colors as $color)
                                        <label class="color-radio" style="background-color: {{ $color->name }};">
                                            <input type="radio" name="variant[0][color_id]" value="{{ $color->id }}" style="display: none;">
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="size">Kích thước</label>
                                <div class="size-options">
                                    @foreach($sizes as $size)
                                        <label class="size-option">
                                            <input type="radio" name="variant[0][size_id]" value="{{ $size->id }}">
                                            <span>{{ $size->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="variant[0][price]">Giá biến thể</label>
                                <input type="text" name="variant[0][price]" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="variant[0][stock_quantity]">Số lượng tồn kho</label>
                                <input type="text" name="variant[0][stock_quantity]" class="form-control">
                            </div>
                        </div>
                        <!-- Kết thúc biến thể đầu tiên -->

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
        let variantIndex = 1;

        function addVariant() {
            let variantsDiv = document.getElementById('variants');
            let newVariant = `
            <a href="">Biến thể tiếp theo</a>
                <div class="variant-group">
                    <div class="form-group">
                        <label for="variant[${variantIndex}][color_id]">Màu sắc</label>

                        <div class="color-options">
                                    @foreach($colors as $color)
                                        <label class="color-radio" style="background-color: {{ $color->name }};">
                                            <input type="radio" name="variant[${variantIndex}][color_id]" value="{{ $color->id }}" style="display: none;">
                                        </label>
                                    @endforeach
                        </div>
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
                        <input type="text" name="variant[${variantIndex}][price]" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="variant[${variantIndex}][stock_quantity]">Số lượng tồn kho</label>
                        <input type="text" name="variant[${variantIndex}][stock_quantity]" class="form-control" required>
                    </div>
                </div>
            `;
            variantsDiv.insertAdjacentHTML('beforeend', newVariant);
            variantIndex++;
        }

        document.getElementById('addVariantBtn').addEventListener('click', addVariant);
    </script>

    {{-- <button type="button" id="addVariantBtn" class="btn btn-secondary">Thêm biến thể</button> --}}

@endsection
