@extends('layout.client')
@section('content')

    <!-- ======================= Shop Style 1 ======================== -->
    <section class="bg-cover" style="background:url(assets/img/cover-1.jpg) no-repeat;">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="text-center py-5 mt-3 mb-3">
                        <h1 class="ft-medium mb-3">Shop</h1>
                        <ul class="shop_categories_list m-0 p-0">
                            <li><a href="#">Men</a></li>
                            <li><a href="#">Speakers</a></li>
                            <li><a href="#">Women</a></li>
                            <li><a href="#">Accessories</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ======================= Shop Style 1 ======================== -->


    <!-- ======================= Filter Wrap Style 1 ======================== -->
    <section class="py-2 br-bottom br-top">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-xl-3 col-lg-4 col-md-5 col-sm-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Shop</a></li>
                            <li class="breadcrumb-item active" aria-current="page">All product</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-xl-9 col-lg-8 col-md-7 col-sm-12">
                    <div class="filter_wraps elspo_wrap d-flex align-items-center justify-content-end">
                        <div class="single_fitres elspo_filter mr-2 br-right">
                            <a href="#filterBox" class="simple-button px-2" role="button"><i
                                    class="lni lni-text-align-right mr-2"></i><span class="hide_mob">Filters</span></a>
                        </div>
                        <div class="single_fitres mr-2 br-right">
                            <form action="{{ route('danhmucsp') }}" method="GET">
                                <select class="custom-select simple" name="sort_by" onchange="this.form.submit()">
                                    <option value="1" {{ request('sort_by') == 1 ? 'selected' : '' }}>Default Sorting
                                    </option>
                                    <option value="2" {{ request('sort_by') == 2 ? 'selected' : '' }}>Low price
                                    </option>
                                    <option value="3" {{ request('sort_by') == 3 ? 'selected' : '' }}>High price
                                    </option>
                                    <option value="price_below_100"
                                        {{ request('sort_by') == 'price_below_100' ? 'selected' : '' }}>Dưới 100.000 VNĐ
                                    </option>
                                    <option value="price_100_500"
                                        {{ request('sort_by') == 'price_100_500' ? 'selected' : '' }}>100.000 - 500.000 VNĐ
                                    </option>
                                    <option value="price_500_1000"
                                        {{ request('sort_by') == 'price_500_1000' ? 'selected' : '' }}>500.000 - 1.000.000
                                        VNĐ</option>
                                    <option value="price_above_1000"
                                        {{ request('sort_by') == 'price_above_1000' ? 'selected' : '' }}>Trên 1.000.000 VNĐ
                                    </option>
                                </select>
                            </form>
                        </div>

                        <div class="single_fitres">
                            <a href="shop-style-4.html" class="simple-button mr-1"><i class="ti-layout-grid3"></i></a>
                            <a href="shop-grid-3.html" class="simple-button mr-1"><i class="ti-layout-grid2"></i></a>
                            <a href="shop-list-view.html" class="simple-button active"><i class="ti-view-list"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row align-items-center justify-content-center">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="collapse show" id="filterBox">
                        <div class="card py-3 b-0">
                            <div class="row">

                                <!-- Choose Category -->
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                    <div class="single_filter_title mb-2">
                                        <h6 class="mb-0 fs-sm ft-medium text-muted">Choose Categories</h6>
                                    </div>
                                    <div class="single_filter_card mb-2">
                                        <h5><a href="#mens" data-toggle="collapse" class="collapsed" aria-expanded="false"
                                                role="button">Áo nam<i class="accordion-indicator ti-angle-down"></i></a>
                                        </h5>
                                        <div class="collapse" id="mens" data-parent="#mens-categories">
                                            <div class="card-body">
                                                <div class="inner_widget_link">
                                                    <ul class="m-0 p-0">
                                                        <li><a href="#">Pumps & high Heals<span>112</span></a></li>
                                                        <li><a href="#">Sandels<span>82</span></a></li>
                                                        <li><a href="#">Sneakers<span>56</span></a></li>
                                                        <li><a href="#">Boots<span>101</span></a></li>
                                                        <li><a href="#">Casual Shoes<span>212</span></a></li>
                                                        <li><a href="#">Flats Sandel<span>92</span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="single_filter_card">
                                        <h5><a href="#womens" data-toggle="collapse" class="collapsed" aria-expanded="false"
                                                role="button">Quần nam<i class="accordion-indicator ti-angle-down"></i></a>
                                        </h5>
                                        <div class="collapse" id="womens" data-parent="#womens-categories">
                                            <div class="card-body">
                                                <div class="inner_widget_link">
                                                    <ul class="p-0 m-0">
                                                        <li><a href="#">Pumps & high Heals<span>112</span></a></li>
                                                        <li><a href="#">Sandels<span>82</span></a></li>
                                                        <li><a href="#">Sneakers<span>56</span></a></li>
                                                        <li><a href="#">Boots<span>101</span></a></li>
                                                        <li><a href="#">Casual Shoes<span>212</span></a></li>
                                                        <li><a href="#">Flats Sandel<span>92</span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Choose Category -->
                                <!-- Choose Size and Color -->
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">

                                    <form method="GET" action="{{ route('danhmucsp') }}" id="filterForm">
                                        <div class="row justify-content-between">
                                            <div class="col-md-6">
                                                <div class="single_filter_title mb-2">
                                                    <h6 class="mb-0 fs-sm ft-medium text-muted">Choose Size</h6>
                                                </div>
                                                <div class="d-flex flex-wrap pt-2 pb-0">
                                                    @foreach ($sizes as $size)
                                                        <div class="form-check form-option form-check-inline mb-2 mr-2">
                                                            <input class="form-check-input" type="radio" name="size"
                                                                id="size{{ $size->id }}" value="{{ $size->id }}"
                                                                {{ request('size') == $size->id ? 'checked' : '' }}
                                                                onchange="checkAndSubmit()">
                                                            <label class="form-option-label"
                                                                for="size{{ $size->id }}">{{ $size->name }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="single_filter_title mb-2">
                                                    <h6 class="mb-0 fs-sm ft-medium text-muted">Choose Colors</h6>
                                                </div>
                                                <div class="d-flex flex-wrap pt-2 pb-0">
                                                    @foreach ($colors as $color)
                                                        <div class="form-check form-option form-check-inline mb-1 mr-2">
                                                            <input class="form-check-input" type="radio" name="color"
                                                                id="color{{ $color->id }}"
                                                                value="{{ $color->id }}"
                                                                {{ request('color') == $color->id ? 'checked' : '' }}
                                                                onchange="checkAndSubmit()">
                                                            <label class="form-option-label"
                                                                for="color{{ $color->id }}">
                                                                {{ $color->name }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>

                                <script>
                                    // Hàm kiểm tra xem người dùng đã chọn đủ cả size và màu chưa
                                    function checkAndSubmit() {
                                        const sizeSelected = document.querySelector('input[name="size"]:checked');
                                        const colorSelected = document.querySelector('input[name="color"]:checked');

                                        // Nếu cả size và màu đều được chọn, thì submit form
                                        if (sizeSelected && colorSelected) {
                                            document.getElementById('filterForm').submit();
                                        }
                                    }
                                </script>



                                <!-- Choose Category -->
                                {{-- <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                    <div class="single_filter_title mb-2">
                                        <h6 class="mb-0 fs-sm ft-medium text-muted">Filter By Price</h6>
                                    </div>
                                    <div class="side-list mb-2">
                                        <div class="rg-slider">
                                            <input type="text" class="js-range-slider" name="my_range"
                                                value="" />
                                        </div>
                                    </div>
                                </div> --}}

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- ============================= Filter Wrap ============================== -->


    <!-- ======================= All Product List ======================== -->
    <section class="middle">
        <div class="container">

            <!-- row -->
            <div class="row align-items-center rows-products">

                <!-- Single -->
                <div class="row align-items-center rows-products">
                    @foreach ($products as $product)
                        <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                            <div class="product_grid card b-0">
                                <div class="badge bg-success text-white position-absolute ft-regular ab-left text-upper">
                                    Sale</div>
                                <button class="snackbar-wishlist btn btn_love position-absolute ab-right"><i
                                        class="far fa-heart"></i></button>
                                <div class="card-body p-0">
                                    <div class="shop_thumb position-relative">
                                        <a class="card-img-top d-block overflow-hidden" href=""><img
                                                class="card-img-top"
                                                src="{{ asset('storage/' . $product->product->image) }}"
                                                alt="..."></a>
                                        <div
                                            class="product-hover-overlay bg-dark d-flex align-items-center justify-content-center">
                                            <div class="edlio"><a href="#" data-toggle="modal"
                                                    data-target="#quickview" class="text-white fs-sm ft-medium"><i
                                                        class="fas fa-eye mr-1"></i>Quick View</a></div>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="card-footers b-0 pt-3 px-2 bg-white d-flex align-items-start justify-content-center">
                                    <div class="text-left">
                                        <div class="text-center">
                                            <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a
                                                    href="">{{ $product->product->name ?? 'Product Name' }}</a>
                                            </h5>
                                            <div class="elis_rty">
                                                <span class="ft-bold fs-md text-dark">
                                                    @if ($product->min_price === $product->max_price)
                                                        ${{ number_format($product->min_price, 2) }}
                                                        <!-- Nếu chỉ có một giá -->
                                                    @else
                                                        ${{ number_format($product->min_price, 2) }} -
                                                        ${{ number_format($product->max_price, 2) }}
                                                        <!-- Nếu có nhiều giá -->
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- Phân trang -->
            {{-- <div class="pagination">
						{{ $products->links() }}
					</div> --}}
            <!-- row -->

            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 text-center">
                    <a href="#" class="btn stretched-link borders m-auto"><i class="lni lni-reload mr-2"></i>Load
                        More</a>
                </div>
            </div>

        </div>
    </section>
    <!-- ======================= All Product List ======================== -->

    <!-- ======================= Customer Features ======================== -->
    <section class="px-0 py-3 br-top">
        <div class="container">
            <div class="row">

                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                    <div class="d-flex align-items-center justify-content-start py-2">
                        <div class="d_ico">
                            <i class="fas fa-shopping-basket"></i>
                        </div>
                        <div class="d_capt">
                            <h5 class="mb-0">Free Shipping</h5>
                            <span class="text-muted">Capped at $10 per order</span>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                    <div class="d-flex align-items-center justify-content-start py-2">
                        <div class="d_ico">
                            <i class="far fa-credit-card"></i>
                        </div>
                        <div class="d_capt">
                            <h5 class="mb-0">Secure Payments</h5>
                            <span class="text-muted">Up to 6 months installments</span>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                    <div class="d-flex align-items-center justify-content-start py-2">
                        <div class="d_ico">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="d_capt">
                            <h5 class="mb-0">15-Days Returns</h5>
                            <span class="text-muted">Shop with fully confidence</span>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                    <div class="d-flex align-items-center justify-content-start py-2">
                        <div class="d_ico">
                            <i class="fas fa-headphones-alt"></i>
                        </div>
                        <div class="d_capt">
                            <h5 class="mb-0">24x7 Fully Support</h5>
                            <span class="text-muted">Get friendly support</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- ======================= Customer Features ======================== -->

    <!-- Product View Modal -->
    <div class="modal fade lg-modal" id="quickview" tabindex="-1" role="dialog" aria-labelledby="quickviewmodal"
        aria-hidden="true">
        <div class="modal-dialog modal-xl login-pop-form" role="document">
            <div class="modal-content" id="quickviewmodal">
                <div class="modal-headers">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="ti-close"></span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="quick_view_wrap">

                        <div class="quick_view_thmb">
                            <div class="quick_view_slide">
                                <div class="single_view_slide"><img src="assets/img/product/1.jpg" class="img-fluid"
                                        alt="" /></div>
                                <div class="single_view_slide"><img src="assets/img/product/2.jpg" class="img-fluid"
                                        alt="" /></div>
                                <div class="single_view_slide"><img src="assets/img/product/3.jpg" class="img-fluid"
                                        alt="" /></div>
                                <div class="single_view_slide"><img src="assets/img/product/4.jpg" class="img-fluid"
                                        alt="" /></div>
                            </div>
                        </div>

                        <div class="quick_view_capt">
                            <div class="prd_details">

                                <div class="prt_01 mb-1"><span class="text-light bg-info rounded px-2 py-1">Dresses</span>
                                </div>
                                <div class="prt_02 mb-2">
                                    <h2 class="ft-bold mb-1">Women Striped Shirt Dress</h2>
                                    <div class="text-left">
                                        <div class="star-rating align-items-center d-flex justify-content-left mb-1 p-0">
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star"></i>
                                            <span class="small">(412 Reviews)</span>
                                        </div>
                                        <div class="elis_rty"><span
                                                class="ft-medium text-muted line-through fs-md mr-2">$199</span><span
                                                class="ft-bold theme-cl fs-lg mr-2">$110</span><span
                                                class="ft-regular text-danger bg-light-danger py-1 px-2 fs-sm">Out of
                                                Stock</span></div>
                                    </div>
                                </div>

                                <div class="prt_03 mb-3">
                                    <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium
                                        voluptatum deleniti atque corrupti quos dolores.</p>
                                </div>

                                <div class="prt_04 mb-2">
                                    <p class="d-flex align-items-center mb-0 text-dark ft-medium">Color:</p>
                                    <div class="text-left">
                                        <div class="form-check form-option form-check-inline mb-1">
                                            <input class="form-check-input" type="radio" name="color8"
                                                id="white8">
                                            <label class="form-option-label rounded-circle" for="white8"><span
                                                    class="form-option-color rounded-circle blc7"></span></label>
                                        </div>
                                        <div class="form-check form-option form-check-inline mb-1">
                                            <input class="form-check-input" type="radio" name="color8"
                                                id="blue8">
                                            <label class="form-option-label rounded-circle" for="blue8"><span
                                                    class="form-option-color rounded-circle blc2"></span></label>
                                        </div>
                                        <div class="form-check form-option form-check-inline mb-1">
                                            <input class="form-check-input" type="radio" name="color8"
                                                id="yellow8">
                                            <label class="form-option-label rounded-circle" for="yellow8"><span
                                                    class="form-option-color rounded-circle blc5"></span></label>
                                        </div>
                                        <div class="form-check form-option form-check-inline mb-1">
                                            <input class="form-check-input" type="radio" name="color8"
                                                id="pink8">
                                            <label class="form-option-label rounded-circle" for="pink8"><span
                                                    class="form-option-color rounded-circle blc3"></span></label>
                                        </div>
                                        <div class="form-check form-option form-check-inline mb-1">
                                            <input class="form-check-input" type="radio" name="color8"
                                                id="red">
                                            <label class="form-option-label rounded-circle" for="red"><span
                                                    class="form-option-color rounded-circle blc4"></span></label>
                                        </div>
                                        <div class="form-check form-option form-check-inline mb-1">
                                            <input class="form-check-input" type="radio" name="color8"
                                                id="green">
                                            <label class="form-option-label rounded-circle" for="green"><span
                                                    class="form-option-color rounded-circle blc6"></span></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="prt_04 mb-4">
                                    <p class="d-flex align-items-center mb-0 text-dark ft-medium">Size:</p>
                                    <div class="text-left pb-0 pt-2">
                                        <div class="form-check size-option form-option form-check-inline mb-2">
                                            <input class="form-check-input" type="radio" name="size" id="28"
                                                checked="">
                                            <label class="form-option-label" for="28">28</label>
                                        </div>
                                        <div class="form-check form-option size-option  form-check-inline mb-2">
                                            <input class="form-check-input" type="radio" name="size"
                                                id="30">
                                            <label class="form-option-label" for="30">30</label>
                                        </div>
                                        <div class="form-check form-option size-option  form-check-inline mb-2">
                                            <input class="form-check-input" type="radio" name="size"
                                                id="32">
                                            <label class="form-option-label" for="32">32</label>
                                        </div>
                                        <div class="form-check form-option size-option  form-check-inline mb-2">
                                            <input class="form-check-input" type="radio" name="size"
                                                id="34">
                                            <label class="form-option-label" for="34">34</label>
                                        </div>
                                        <div class="form-check form-option size-option  form-check-inline mb-2">
                                            <input class="form-check-input" type="radio" name="size"
                                                id="36">
                                            <label class="form-option-label" for="36">36</label>
                                        </div>
                                        <div class="form-check form-option size-option  form-check-inline mb-2">
                                            <input class="form-check-input" type="radio" name="size"
                                                id="38">
                                            <label class="form-option-label" for="38">38</label>
                                        </div>
                                        <div class="form-check form-option size-option  form-check-inline mb-2">
                                            <input class="form-check-input" type="radio" name="size"
                                                id="40">
                                            <label class="form-option-label" for="40">40</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="prt_05 mb-4">
                                    <div class="form-row mb-7">
                                        <div class="col-12 col-lg-auto">
                                            <!-- Quantity -->
                                            <select class="mb-2 custom-select">
                                                <option value="1" selected="">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-lg">
                                            <!-- Submit -->
                                            <button type="submit" class="btn btn-block custom-height bg-dark mb-2">
                                                <i class="lni lni-shopping-basket mr-2"></i>Add to Cart
                                            </button>
                                        </div>
                                        <div class="col-12 col-lg-auto">
                                            <!-- Wishlist -->
                                            <button class="btn custom-height btn-default btn-block mb-2 text-dark"
                                                data-toggle="button">
                                                <i class="lni lni-heart mr-2"></i>Wishlist
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="prt_06">
                                    <p class="mb-0 d-flex align-items-center">
                                        <span class="mr-4">Share:</span>
                                        <a class="d-inline-flex align-items-center justify-content-center p-3 gray circle fs-sm text-muted mr-2"
                                            href="#!">
                                            <i class="fab fa-twitter position-absolute"></i>
                                        </a>
                                        <a class="d-inline-flex align-items-center justify-content-center p-3 gray circle fs-sm text-muted mr-2"
                                            href="#!">
                                            <i class="fab fa-facebook-f position-absolute"></i>
                                        </a>
                                        <a class="d-inline-flex align-items-center justify-content-center p-3 gray circle fs-sm text-muted"
                                            href="#!">
                                            <i class="fab fa-pinterest-p position-absolute"></i>
                                        </a>
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

    <!-- Log In Modal -->
    <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="loginmodal"
        aria-hidden="true">
        <div class="modal-dialog modal-xl login-pop-form" role="document">
            <div class="modal-content" id="loginmodal">
                <div class="modal-headers">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="ti-close"></span>
                    </button>
                </div>

                <div class="modal-body p-5">
                    <div class="text-center mb-4">
                        <h2 class="m-0 ft-regular">Login</h2>
                    </div>

                    <form>
                        <div class="form-group">
                            <label>User Name</label>
                            <input type="text" class="form-control" placeholder="Username*">
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" placeholder="Password*">
                        </div>

                        <div class="form-group">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="flex-1">
                                    <input id="dd" class="checkbox-custom" name="dd" type="checkbox">
                                    <label for="dd" class="checkbox-custom-label">Remember Me</label>
                                </div>
                                <div class="eltio_k2">
                                    <a href="#">Lost Your Password?</a>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit"
                                class="btn btn-md full-width bg-dark text-light fs-md ft-medium">Login</button>
                        </div>

                        <div class="form-group text-center mb-0">
                            <p class="extra">Not a member?<a href="#et-register-wrap" class="text-dark"> Register</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

    <!-- Search -->
    <div class="w3-ch-sideBar w3-bar-block w3-card-2 w3-animate-right" style="display:none;right:0;" id="Search">
        <div class="rightMenu-scroll">
            <div class="d-flex align-items-center justify-content-between slide-head py-3 px-3">
                <h4 class="cart_heading fs-md ft-medium mb-0">Search Products</h4>
                <button onclick="closeSearch()" class="close_slide"><i class="ti-close"></i></button>
            </div>

            <div class="cart_action px-3 py-4">
                <form class="form m-0 p-0">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Product Keyword.." />
                    </div>

                    <div class="form-group">
                        <select class="custom-select">
                            <option value="1" selected="">Choose Category</option>
                            <option value="2">Men's Store</option>
                            <option value="3">Women's Store</option>
                            <option value="4">Kid's Fashion</option>
                            <option value="5">Inner Wear</option>
                        </select>
                    </div>

                    <div class="form-group mb-0">
                        <button type="button" class="btn d-block full-width btn-dark">Search Product</button>
                    </div>
                </form>
            </div>

            <div class="d-flex align-items-center justify-content-center br-top br-bottom py-2 px-3">
                <h4 class="cart_heading fs-md mb-0">Hot Categories</h4>
            </div>

            <div class="cart_action px-3 py-3">
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-4 mb-3">
                        <div class="cats_side_wrap text-center">
                            <div class="sl_cat_01">
                                <div class="d-inline-flex align-items-center justify-content-center p-3 circle mb-2 gray">
                                    <a href="javascript:void(0);" class="d-block"><img src="assets/img/tshirt.png"
                                            class="img-fluid" width="40" alt="" /></a>
                                </div>
                            </div>
                            <div class="sl_cat_02">
                                <h6 class="m-0 ft-medium fs-sm"><a href="javascript:void(0);">T-Shirts</a></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-4 mb-3">
                        <div class="cats_side_wrap text-center">
                            <div class="sl_cat_01">
                                <div class="d-inline-flex align-items-center justify-content-center p-3 circle mb-2 gray">
                                    <a href="javascript:void(0);" class="d-block"><img src="assets/img/pant.png"
                                            class="img-fluid" width="40" alt="" /></a>
                                </div>
                            </div>
                            <div class="sl_cat_02">
                                <h6 class="m-0 ft-medium fs-sm"><a href="javascript:void(0);">Pants</a></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-4 mb-3">
                        <div class="cats_side_wrap text-center">
                            <div class="sl_cat_01">
                                <div class="d-inline-flex align-items-center justify-content-center p-3 circle mb-2 gray">
                                    <a href="javascript:void(0);" class="d-block"><img src="assets/img/fashion.png"
                                            class="img-fluid" width="40" alt="" /></a>
                                </div>
                            </div>
                            <div class="sl_cat_02">
                                <h6 class="m-0 ft-medium fs-sm"><a href="javascript:void(0);">Women's</a></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-4 mb-3">
                        <div class="cats_side_wrap text-center">
                            <div class="sl_cat_01">
                                <div class="d-inline-flex align-items-center justify-content-center p-3 circle mb-2 gray">
                                    <a href="javascript:void(0);" class="d-block"><img src="assets/img/sneakers.png"
                                            class="img-fluid" width="40" alt="" /></a>
                                </div>
                            </div>
                            <div class="sl_cat_02">
                                <h6 class="m-0 ft-medium fs-sm"><a href="javascript:void(0);">Shoes</a></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-4 mb-3">
                        <div class="cats_side_wrap text-center">
                            <div class="sl_cat_01">
                                <div class="d-inline-flex align-items-center justify-content-center p-3 circle mb-2 gray">
                                    <a href="javascript:void(0);" class="d-block"><img src="assets/img/television.png"
                                            class="img-fluid" width="40" alt="" /></a>
                                </div>
                            </div>
                            <div class="sl_cat_02">
                                <h6 class="m-0 ft-medium fs-sm"><a href="javascript:void(0);">Television</a></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-4 mb-3">
                        <div class="cats_side_wrap text-center">
                            <div class="sl_cat_01">
                                <div class="d-inline-flex align-items-center justify-content-center p-3 circle mb-2 gray">
                                    <a href="javascript:void(0);" class="d-block"><img src="assets/img/accessories.png"
                                            class="img-fluid" width="40" alt="" /></a>
                                </div>
                            </div>
                            <div class="sl_cat_02">
                                <h6 class="m-0 ft-medium fs-sm"><a href="javascript:void(0);">Accessories</a></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Wishlist -->
    <div class="w3-ch-sideBar w3-bar-block w3-card-2 w3-animate-right" style="display:none;right:0;" id="Wishlist">
        <div class="rightMenu-scroll">
            <div class="d-flex align-items-center justify-content-between slide-head py-3 px-3">
                <h4 class="cart_heading fs-md ft-medium mb-0">Saved Products</h4>
                <button onclick="closeWishlist()" class="close_slide"><i class="ti-close"></i></button>
            </div>
            <div class="right-ch-sideBar">

                <div class="cart_select_items py-2">
                    <!-- Single Item -->
                    <div class="d-flex align-items-center justify-content-between br-bottom px-3 py-3">
                        <div class="cart_single d-flex align-items-center">
                            <div class="cart_selected_single_thumb">
                                <a href="#"><img src="assets/img/product/4.jpg" width="60" class="img-fluid"
                                        alt="" /></a>
                            </div>
                            <div class="cart_single_caption pl-2">
                                <h4 class="product_title fs-sm ft-medium mb-0 lh-1">Women Striped Shirt Dress</h4>
                                <p class="mb-2"><span class="text-dark ft-medium small">36</span>, <span
                                        class="text-dark small">Red</span></p>
                                <h4 class="fs-md ft-medium mb-0 lh-1">$129</h4>
                            </div>
                        </div>
                        <div class="fls_last"><button class="close_slide gray"><i class="ti-close"></i></button></div>
                    </div>

                    <!-- Single Item -->
                    <div class="d-flex align-items-center justify-content-between br-bottom px-3 py-3">
                        <div class="cart_single d-flex align-items-center">
                            <div class="cart_selected_single_thumb">
                                <a href="#"><img src="assets/img/product/7.jpg" width="60" class="img-fluid"
                                        alt="" /></a>
                            </div>
                            <div class="cart_single_caption pl-2">
                                <h4 class="product_title fs-sm ft-medium mb-0 lh-1">Girls Floral Print Jumpsuit</h4>
                                <p class="mb-2"><span class="text-dark ft-medium small">36</span>, <span
                                        class="text-dark small">Red</span></p>
                                <h4 class="fs-md ft-medium mb-0 lh-1">$129</h4>
                            </div>
                        </div>
                        <div class="fls_last"><button class="close_slide gray"><i class="ti-close"></i></button></div>
                    </div>

                    <!-- Single Item -->
                    <div class="d-flex align-items-center justify-content-between px-3 py-3">
                        <div class="cart_single d-flex align-items-center">
                            <div class="cart_selected_single_thumb">
                                <a href="#"><img src="assets/img/product/8.jpg" width="60" class="img-fluid"
                                        alt="" /></a>
                            </div>
                            <div class="cart_single_caption pl-2">
                                <h4 class="product_title fs-sm ft-medium mb-0 lh-1">Girls Solid A-Line Dress</h4>
                                <p class="mb-2"><span class="text-dark ft-medium small">30</span>, <span
                                        class="text-dark small">Blue</span></p>
                                <h4 class="fs-md ft-medium mb-0 lh-1">$100</h4>
                            </div>
                        </div>
                        <div class="fls_last"><button class="close_slide gray"><i class="ti-close"></i></button></div>
                    </div>

                </div>

                <div class="d-flex align-items-center justify-content-between br-top br-bottom px-3 py-3">
                    <h6 class="mb-0">Subtotal</h6>
                    <h3 class="mb-0 ft-medium">$417</h3>
                </div>

                <div class="cart_action px-3 py-3">
                    <div class="form-group">
                        <button type="button" class="btn d-block full-width btn-dark">Move To Cart</button>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn d-block full-width btn-dark-light">Edit or View</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Cart -->
    <div class="w3-ch-sideBar w3-bar-block w3-card-2 w3-animate-right" style="display:none;right:0;" id="Cart">
        <div class="rightMenu-scroll">
            <div class="d-flex align-items-center justify-content-between slide-head py-3 px-3">
                <h4 class="cart_heading fs-md ft-medium mb-0">Products List</h4>
                <button onclick="closeCart()" class="close_slide"><i class="ti-close"></i></button>
            </div>
            <div class="right-ch-sideBar">

                <div class="cart_select_items py-2">
                    <!-- Single Item -->
                    <div class="d-flex align-items-center justify-content-between br-bottom px-3 py-3">
                        <div class="cart_single d-flex align-items-center">
                            <div class="cart_selected_single_thumb">
                                <a href="#"><img src="assets/img/product/4.jpg" width="60" class="img-fluid"
                                        alt="" /></a>
                            </div>
                            <div class="cart_single_caption pl-2">
                                <h4 class="product_title fs-sm ft-medium mb-0 lh-1">Women Striped Shirt Dress</h4>
                                <p class="mb-2"><span class="text-dark ft-medium small">36</span>, <span
                                        class="text-dark small">Red</span></p>
                                <h4 class="fs-md ft-medium mb-0 lh-1">$129</h4>
                            </div>
                        </div>
                        <div class="fls_last"><button class="close_slide gray"><i class="ti-close"></i></button></div>
                    </div>

                    <!-- Single Item -->
                    <div class="d-flex align-items-center justify-content-between br-bottom px-3 py-3">
                        <div class="cart_single d-flex align-items-center">
                            <div class="cart_selected_single_thumb">
                                <a href="#"><img src="assets/img/product/7.jpg" width="60" class="img-fluid"
                                        alt="" /></a>
                            </div>
                            <div class="cart_single_caption pl-2">
                                <h4 class="product_title fs-sm ft-medium mb-0 lh-1">Girls Floral Print Jumpsuit</h4>
                                <p class="mb-2"><span class="text-dark ft-medium small">36</span>, <span
                                        class="text-dark small">Red</span></p>
                                <h4 class="fs-md ft-medium mb-0 lh-1">$129</h4>
                            </div>
                        </div>
                        <div class="fls_last"><button class="close_slide gray"><i class="ti-close"></i></button></div>
                    </div>

                    <!-- Single Item -->
                    <div class="d-flex align-items-center justify-content-between px-3 py-3">
                        <div class="cart_single d-flex align-items-center">
                            <div class="cart_selected_single_thumb">
                                <a href="#"><img src="assets/img/product/8.jpg" width="60" class="img-fluid"
                                        alt="" /></a>
                            </div>
                            <div class="cart_single_caption pl-2">
                                <h4 class="product_title fs-sm ft-medium mb-0 lh-1">Girls Solid A-Line Dress</h4>
                                <p class="mb-2"><span class="text-dark ft-medium small">30</span>, <span
                                        class="text-dark small">Blue</span></p>
                                <h4 class="fs-md ft-medium mb-0 lh-1">$100</h4>
                            </div>
                        </div>
                        <div class="fls_last"><button class="close_slide gray"><i class="ti-close"></i></button></div>
                    </div>

                </div>

                <div class="d-flex align-items-center justify-content-between br-top br-bottom px-3 py-3">
                    <h6 class="mb-0">Subtotal</h6>
                    <h3 class="mb-0 ft-medium">$1023</h3>
                </div>

                <div class="cart_action px-3 py-3">
                    <div class="form-group">
                        <button type="button" class="btn d-block full-width btn-dark">Checkout Now</button>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn d-block full-width btn-dark-light">Edit or View</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <a id="back2Top" class="top-scroll" title="Back to top" href="#"><i class="ti-arrow-up"></i></a>


    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->

    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/ion.rangeSlider.min.js"></script>
    <script src="assets/js/slick.js"></script>
    <script src="assets/js/slider-bg.js"></script>
    <script src="assets/js/lightbox.js"></script>
    <script src="assets/js/smoothproducts.js"></script>
    <script src="assets/js/snackbar.min.js"></script>
    <script src="assets/js/jQuery.style.switcher.js"></script>
    <script src="assets/js/custom.js"></script>
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->

    <script>
        function openWishlist() {
            document.getElementById("Wishlist").style.display = "block";
        }

        function closeWishlist() {
            document.getElementById("Wishlist").style.display = "none";
        }
    </script>

    <script>
        function openCart() {
            document.getElementById("Cart").style.display = "block";
        }

        function closeCart() {
            document.getElementById("Cart").style.display = "none";
        }
    </script>

    <script>
        function openSearch() {
            document.getElementById("Search").style.display = "block";
        }

        function closeSearch() {
            document.getElementById("Search").style.display = "none";
        }
    </script>
    </div>
@endsection
