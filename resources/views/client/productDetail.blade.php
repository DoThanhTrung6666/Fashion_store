@extends('layout.client')
@section('content')
<div class="clearfix"></div>
<!-- ============================================================== -->
<!-- Top header  -->
<!-- ============================================================== -->

<!-- ======================= Top Breadcrubms ======================== -->
<div class="gray py-3">
    <div class="container">
        <div class="row">
            <div class="colxl-12 col-lg-12 col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Library</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- ======================= Top Breadcrubms ======================== -->

<!-- ======================= Product Detail ======================== -->
<form action="{{route('cart.add')}}" method="POST">
    @csrf
<section class="middle">
    <div class="container">
        <div class="row">

            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                {{-- <div class=""><img src="{{Storage::url($detail->image)}}" width="100%" alt=""><br>LOADING IMAGES</div> --}}

                <div class="sp-wrap" >
                    @foreach ($detail->variants as $image )
                        <a href=""><img src="{{Storage::url($image->image_variant)}}" alt="" width="100"></a>
                    @endforeach
                </div>

            </div>

            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="prd_details">

                    <div class="prt_01 mb-2"><span class="text-success bg-light-success rounded px-2 py-1">{{$detail->category->name}}</span></div>
                    <div class="prt_02 mb-3">
                        <h2 class="ft-bold mb-1">{{$detail->name}}</h2>
                        <div class="text-left">
                            {{-- <div class="star-rating align-items-center d-flex justify-content-left mb-1 p-0">
                                <i class="fas fa-star filled"></i>
                                <i class="fas fa-star filled"></i>
                                <i class="fas fa-star filled"></i>
                                <i class="fas fa-star filled"></i>
                                <i class="fas fa-star"></i>
                                <span class="small">(412 Reviews)</span>
                            </div> --}}

                            @if($flashSales)
                                <h3 style="color: red">Đang diễn ra chương trình flash-sale</h3>
                                <div class="elis_rty">Giá gốc :<span class="ft-medium text-muted line-through fs-md mr-2">{{number_format($detail->price)}}</span>vnđ<br>Giá sau khi giảm:<span class="ft-bold theme-cl fs-lg">{{$flashSales->price}}</span> vnđ</div>
                            @else
                                <div class="elis_rty"><span class="ft-bold theme-cl fs-lg">Giá sản phẩm : {{number_format($detail->price)}} VNĐ</span></div>
                            @endif

                        </div>
                    </div>

                    <div class="prt_03 mb-4">
                        <p></p>
                    </div>

                    <div class="prt_04 mb-4">
                        {{-- <p class="d-flex align-items-center mb-1">Category:<strong class="fs-sm text-dark ft-medium ml-1">{{$detail->category->name}}</strong></p> --}}
                        {{-- <p class="d-flex align-items-center mb-0">SKU:<strong class="fs-sm text-dark ft-medium ml-1">KUMO42568</strong></p> --}}

                    </div>

{{-- dành cho size và color  --}}
<div class="product-options">
    <!-- Chọn màu sắc -->
    <div class="form-group">
        <label for="color">Màu sắc</label>
        <div class="size-options">
            {{-- @foreach($groupByColor as $colorName=>$variants)
                <label class="size-option">
                    <input type="radio" name="color_id" value="{{ $variants->first()->color->id }}" onclick="updateSizes({{ $variants->first()->color->id }})"/>
                    <span>{{ $colorName }}</span>
                </label>
            @endforeach --}}
            @foreach($variants->groupBy('color.id') as $colorId => $colorVariants)
            <label class="size-option">
                <input type="radio" name="color_id" value="{{ $colorId }}" onclick="updateSizes({{ $colorId }})" />
                <span>{{ $colorVariants->first()->color->name }}</span>
            </label>
        @endforeach
        </div>
    </div>
    {{-- <div class="form-group">
        <label for="size">Kích thước</label>
        <div class="size-options">
            @foreach($groupByColor as $colorName=>$variants)
                <label class="size-option">

                    <input type="radio" name="color_id" value="{{ $variants->first()->color->id }}" />

                    <span>{{ $colorName }}</span>
                </label>
            @endforeach
        </div>
    </div> --}}
    <!-- Chọn size -->
    <div class="form-group">
        <label for="size">Kích thước</label>
        <div class="size-options" id="size-options">
            {{-- @foreach($groupBySize as $sizeName=>$variants)
                <label class="size-option">
                    <input type="radio" name="size_id" value="{{ $variants->first()->size->id }}" disabled />
                    <span>{{ $sizeName }}</span>
                </label>
            @endforeach --}}
            @foreach($variants->groupBy('size.id') as $sizeId => $sizeVariants)
            <label class="size-option">
                <input type="radio" name="size_id" value="{{ $sizeId }}" onclick="updateColors({{ $sizeId }})" />
                <span>{{ $sizeVariants->first()->size->name }}</span>
            </label>
        @endforeach
        </div>
    </div>
    <span>
        @if(session('error'))
            <p style="color: red">{{session('error')}}</p>
        @endif
    </span>
    <span>
        @if(session('success'))
            <p style="color: red">{{session('success')}}</p>
        @endif
    </span>
    <p>Số lượng  </p>
    {{-- thêm product_id để so sánh  --}}
    <input type="hidden" name="product_id" value="{{ $detail->id }}">

    <script>
        const variants = @json($variants->toArray());

function updateSizes(colorId) {
    const sizeOptions = document.querySelectorAll('#size-options .size-option');
    sizeOptions.forEach(option => {
        const input = option.querySelector('input');
        input.checked = false;
        option.classList.add('disabled'); // Thêm class màu tối
    });

    // Lọc các kích thước phù hợp với màu đã chọn
    const availableSizes = variants.filter(variant => variant.color_id === colorId && variant.stock_quantity > 0).map(variant => variant.size_id);

    sizeOptions.forEach(option => {
        const input = option.querySelector('input');
        if (availableSizes.includes(parseInt(input.value))) {
            option.classList.remove('disabled'); // Bỏ màu tối
        }
    });
}

function updateColors(sizeId) {
    const colorOptions = document.querySelectorAll('#color-options .color-option');
    colorOptions.forEach(option => {
        const input = option.querySelector('input');
        input.checked = false;
        option.classList.add('disabled'); // Thêm class màu tối
    });

    // Lọc các màu phù hợp với kích thước đã chọn
    const availableColors = variants.filter(variant => variant.size_id === sizeId && variant.stock_quantity > 0).map(variant => variant.color_id);

    colorOptions.forEach(option => {
        const input = option.querySelector('input');
        if (availableColors.includes(parseInt(input.value))) {
            option.classList.remove('disabled'); // Bỏ màu tối
        }
    });
}
    </script>
</div>
{{-- <input type="hidden" name="product_variant_id" id="product_variant_id"> --}}
{{-- dành cho size và color  --}}
                    <div class="prt_05 mb-4">
                        <div class="form-row mb-7">
                            <div class="col-12 col-lg-auto">
                                <!-- Quantity -->
                                {{-- <select class="mb-2 custom-select" name="quantity">
                                    <option value="1" selected="">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select> --}}
                                <input type="number" class="btn custom-height btn-default btn-block mb-2 text-dark" name="quantity" value="1">
                            </div>
                            <div class="col-12 col-lg">
                                <!-- Submit -->
                                <button type="submit" name="action" value="add_to_cart" class="btn btn-block custom-height bg-dark mb-2">
                                    <i class="lni lni-shopping-basket mr-2"></i>Thêm vào giỏ hàng
                                </button>
                            </div>
                            <div class="col-12 col-lg-auto">
                                <!-- Wishlist -->
                                {{-- <a href="" class="btn custom-height btn-default btn-block mb-2 text-dark">
                                    <i class="lni lni-shopping-basket mr-2"></i>Mua ngay
                                </a> --}}
                                <button type="submit" name="action" value="buy_now" class="btn custom-height btn-default btn-block mb-2 text-dark">
                                    <i class="lni lni-shopping-basket mr-2"></i>Mua ngay
                                </button>

                            </div>
                      </div>
                    </div>

                    <div class="prt_06">
                        <p class="mb-0 d-flex align-items-center">
                          <span class="mr-4">Share:</span>
                          <a class="d-inline-flex align-items-center justify-content-center p-3 gray circle fs-sm text-muted mr-2" href="#!">
                            <i class="fab fa-twitter position-absolute"></i>
                          </a>
                          <a class="d-inline-flex align-items-center justify-content-center p-3 gray circle fs-sm text-muted mr-2" href="#!">
                            <i class="fab fa-facebook-f position-absolute"></i>
                          </a>
                          <a class="d-inline-flex align-items-center justify-content-center p-3 gray circle fs-sm text-muted" href="#!">
                            <i class="fab fa-pinterest-p position-absolute"></i>
                          </a>
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>

</section>
</form>
<!-- ======================= Product Detail End ======================== -->

<!-- ======================= Product Description ======================= -->
<section class="middle">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-xl-11 col-lg-12 col-md-12 col-sm-12">
                <ul class="nav nav-tabs b-0 d-flex align-items-center justify-content-center simple_tab_links mb-4" id="myTab" role="tablist">
                    {{-- <li class="nav-item" role="presentation">
                        <a class="nav-link" href="#reviews" id="reviews-tab" data-toggle="tab" role="tab" aria-controls="reviews" aria-selected="false">Reviews</a>
                    </li> --}}
                </ul>

                <div class="tab-content" id="myTabContent">

                    <!-- Additional Content -->




                    <!-- Thông tin sản phẩm -->
<div class="product-info">
    <!-- Chi tiết sản phẩm, giá cả, mô tả... -->
</div>

<!-- Bình luận về sản phẩm -->
<div class="reviews_info">
    @foreach($comments as $comment)
        <div class="single_rev d-flex align-items-start br-bottom py-3">
            <div class="single_rev_thumb">
                <img src="assets/img/team-1.jpg" class="img-fluid circle" width="90" alt="" />
            </div>
            <div class="single_rev_caption d-flex align-items-start pl-3">
                <div class="single_capt_left">
                    <h5 class="mb-0 fs-md ft-medium lh-1">{{ $comment->user->name }}</h5>
                    <span class="small">{{ $comment->created_at->format('d M Y') }}</span>
                    <p>{{ $comment->content }}</p>
                </div>
                <div class="single_capt_right">
                    <div class="star-rating align-items-center d-flex justify-content-left mb-1 p-0">
                        @for($i = 0; $i < $comment->rating; $i++)
                            <i class="fas fa-star filled"></i>
                        @endfor
                        @for($i = $comment->rating; $i < 5; $i++)
                            <i class="fas fa-star"></i>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>






                </div>
            </div>
        </div>
    </div>
</section>
<!-- ======================= Product Description End ==================== -->

<!-- ======================= Similar Products Start ============================ -->
<section class="middle pt-0">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="sec_title position-relative text-center">
                    <h2 class="off_title">Sản phẩm cùng loại</h2>
                    <h3 class="ft-bold pt-3">Sản phẩm cùng loại</h3>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="slide_items">

                    @foreach ($relatedProducts as $product)
                        <!-- single Item -->
                        <div class="single_itesm">
                            <div class="product_grid card b-0 mb-0">
                                <div class="badge bg-success text-white position-absolute ft-regular ab-left text-upper">Sale</div>
                                <button class="snackbar-wishlist btn btn_love position-absolute ab-right"><i class="far fa-heart"></i></button>
                                <div class="card-body p-0">
                                    <div class="shop_thumb position-relative">
                                        <a class="card-img-top d-block overflow-hidden" href="{{route('detail.show',$product->id)}}"><img class="card-img-top" src="{{Storage::url($product->image)}}" alt="..."></a>
                                        <div class="product-hover-overlay bg-dark d-flex align-items-center justify-content-center">
                                            <div class="edlio"><a href="#" data-toggle="modal" data-target="#quickview" class="text-white fs-sm ft-medium"><i class="fas fa-eye mr-1"></i>Quick View</a></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer b-0 p-3 pb-0 d-flex align-items-start justify-content-center">
                                    <div class="text-left">
                                        <div class="text-center">
                                            <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="shop-single-v1.html">{{$product->name}}</a></h5>
                                            <div class="elis_rty"><span class="ft-bold fs-md text-dark">{{$product->price}} VNĐ</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach


                </div>
            </div>
        </div>

    </div>
</section>
<!-- ======================= Similar Products Start ============================ -->
@endsection
