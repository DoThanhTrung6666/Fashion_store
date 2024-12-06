@extends('layout.client')
@section('content')
<div class="home-slider margin-bottom-0">

    <!-- Slide -->
    <div data-background-image="assets/img/bannershop.jpg" class="item">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="home-slider-container">

                        <!-- Slide Title -->
                        <div class="home-slider-desc">
                            <div class="home-slider-title mb-4">
                                <h5 class="theme-cl fs-sm ft-ragular mb-0">Winter Collection</h5>
                                <h1 class="mb-1 ft-bold lg-heading">New Winter<br>Collections 2024</h1>
                                <span class="trending">There's nothing like trend</span>
                            </div>

                            <a href="{{route('danhmucsp')}}" class="btn stretched-link borders">Shop Now<i class="lni lni-arrow-right ml-2"></i></a>
                        </div>
                        <!-- Slide Title / End -->

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Slide -->
    <div data-background-image="{{asset('assets/img/bannershop1.jpg')}}" class="item">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="home-slider-container">

                        <!-- Slide Title -->
                        <div class="home-slider-desc">
                            <div class="home-slider-title mb-4">
                                <h5 class="theme-cl fs-sm ft-ragular mb-0">Winter Collection</h5>
                                <h1 class="mb-1 ft-bold lg-heading">New Winter<br>Collections 2024</h1>
                                <span class="trending">There's nothing like trend</span>
                            </div>

                            <a href="#" class="btn stretched-link borders">Shop Now<i class="lni lni-arrow-right ml-2"></i></a>
                        </div>
                        <!-- Slide Title / End -->

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Slide -->
    <div data-background-image="assets/img/b-3.png" class="item">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="home-slider-container">

                        <!-- Slide Title -->
                        <div class="home-slider-desc">
                            <div class="home-slider-title mb-4">
                                <h5 class="theme-cl fs-sm ft-ragular mb-0">Winter Collection</h5>
                                <h1 class="mb-1 ft-bold lg-heading">New Winter<br>Collections 2021</h1>
                                <span class="trending">There's nothing like trend</span>
                            </div>

                            <a href="#" class="btn stretched-link borders">Shop Now<i class="lni lni-arrow-right ml-2"></i></a>
                        </div>
                        <!-- Slide Title / End -->

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- ============================ Hero Banner End ================================== -->

<!-- ======================= Flash sale ======================== -->
@if($flashSales->isEmpty())
    {{-- <p>Chương trình đã kết thúc</p> --}}
@else
<section class="middle gray">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="sec_title position-relative text-center">
                    <h2 class="off_title">Chương trình flash sale</h2>
                    <h3 class="ft-bold pt-3">Chương trình flash sale </h3>
                    <div class="row">
                        <div class="col-md-12">
                            <h3 style="color: red"><span id="countdown"></span></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- row -->
        <div class="row align-items-center rows-products">

            @foreach ($flashSales as $flashSale)
            @foreach ($flashSale->flashSaleItems as $item)

            <!-- Single -->
            <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                <div class="product_grid card b-0">
                    <div class="badge bg-success text-white position-absolute ft-regular ab-left text-upper">{{ number_format($flashSale->sale->discount_percentage) }}%</div>
                    <div class="card-body p-0">
                        <div class="shop_thumb position-relative">
                            <a class="card-img-top d-block overflow-hidden" href="{{ route('detail.show', $item->product->id) }}"><img class="card-img-top" src="{{Storage::url($item->product->image)}}" alt="..."></a>
                            <div class="product-hover-overlay bg-dark d-flex align-items-center justify-content-center">
                                <div class="edlio"><a href="#" data-toggle="modal" data-target="#quickview" class="text-white fs-sm ft-medium"><i class="fas fa-eye mr-1"></i>Quick View</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer b-0 p-0 pt-2">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="text-left">
                                {{-- @foreach ($flashSale->productVariant->color as $color)
                                <div class="form-check form-option form-check-inline mb-1">
                                    <input class="form-check-input" type="radio" name="color1" id="white" checked="">
                                    <label class="form-option-label small rounded-circle" for="white" style="background-color: {{$color->name}};"></label> --}}
                                    {{-- <label class="color-radio" style="background-color: {{$color->name}};"></label> --}}
                                 {{-- </div>
                                @endforeach --}}
                            </div>
                            <div class="text-right">
                                <button class="btn auto btn_love snackbar-wishlist"><i class="far fa-heart"></i></button>
                            </div>
                        </div>
                        <div class="text-left">
                            <p class="fw-bolder fs-md mb-0 lh-1 mb-1"><a  href="{{ route('detail.show', $flashSale->id) }}">{{$item->product->name}}</a></p>
                            <div class="elis_rty">
                                <span class="ft-bold text-dark fs-sm" style="display: flex">
                                <p style="text-decoration:line-through ; width:40%;color:red">{{ rtrim(rtrim(number_format($item->product->price, 2, '.', ','), '0'), '.') }}vnđ</p>
                                <p style="width:60%">{{$item->price}}vnđ</p>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endforeach


@foreach($flashSales as $flashSale)
<script>
    window.onload = function () {
        // Lấy start_time và end_time của flashSale
        var startTime = new Date("{{ \Carbon\Carbon::parse($flashSale->start_time)->toIso8601String() }}").getTime();
        var endTime = new Date("{{ \Carbon\Carbon::parse($flashSale->end_time)->toIso8601String() }}").getTime();
        console.log(startTime);
        var countdown = setInterval(function () {
            var now = new Date().getTime();
            if (now < startTime) {
                // Chương trình chưa bắt đầu, hiển thị thời gian chờ bắt đầu
                var timeUntilStart = startTime - now;
                // console.log(timeUntilStart);
                var days = Math.floor(timeUntilStart / (1000 * 60 * 60 * 24));
                var hours = Math.floor((timeUntilStart % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((timeUntilStart % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((timeUntilStart % (1000 * 60)) / 1000);

                document.getElementById("countdown").innerHTML =
                    `Chương trình bắt đầu sau: ${days}d ${hours}h ${minutes}m ${seconds}s`;
            } else if (now >= startTime && now < endTime) {
                // Chương trình đã bắt đầu, hiển thị thời gian còn lại đến khi kết thúc
                var timeRemaining = endTime - now;

                var days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
                var hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

                document.getElementById("countdown").innerHTML =
                    `Chương trình kết thúc sau: ${days}d ${hours}h ${minutes}m ${seconds}s`;
            } else {
                // Chương trình đã kết thúc
                clearInterval(countdown);
                document.getElementById("countdown").innerHTML = "Chương trình đã kết thúc";
                location.reload();
            }
        }, 1000);
    };
</script>
@endforeach
        </div>
        <!-- row -->

        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="position-relative text-center">
                    <a href="shop-style-1.html" class="btn stretched-link borders">Explore More<i class="lni lni-arrow-right ml-2"></i></a>
                </div>
            </div>
        </div>

    </div>
</section>
@endif

<!-- ======================= All  ======================== -->
<section class="space min">

</section>
<!-- ======================= Products Lists ======================== -->
<section class="space min pt-0">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="sec_title position-relative text-center">
                    <h2 class="off_title">Tất cả sản phẩm</h2>
                    <h3 class="ft-bold pt-3">Tất cả sản phẩm</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">

                <ul class="nav nav-tabs b-0 d-flex align-items-center justify-content-center simple_tab_links mb-4" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="all-tab" href="#all" data-toggle="tab" role="tab" aria-controls="all" aria-selected="true">All</a>
                    </li>
                    @foreach ($categories as $category)
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" href="#{{$category->description}}" id="{{$category->description}}-tab" data-toggle="tab" role="tab" aria-controls="{{$category->description}}" aria-selected="false">{{$category->name}}</a>
                        </li>
                    @endforeach

                </ul>

                <div class="tab-content" id="myTabContent">

                    <!-- All Content -->
                    <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                        <div class="tab_product">
                            <div class="row rows-products">

                                <!-- Single -->
                                @foreach ($allProducts as $value)
                                <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                                    <div class="product_grid card b-0">

                                        @php
                                            // Kiểm tra xem sản phẩm này có tham gia flash sale không
                                            $flashSale = $flashSales->firstWhere('flashSaleId', $value->id);
                                        @endphp

                                        @if($flashSale)
                                            <div class="badge bg-info text-white position-absolute ft-regular ab-left text-upper">{{number_format($flashSale['salePercentage'])}}%</div>
                                        @else
                                            <div class="badge bg-info text-white position-absolute ft-regular ab-left text-upper"></div>
                                        @endif
                                        <div class="card-body p-0">
                                            <div class="shop_thumb position-relative">
                                                <a class="card-img-top d-block overflow-hidden" href="{{ route('detail.show', $value->id) }}"><img class="card-img-top" src="{{Storage::url($value->image)}}" alt="..."></a>
                                                <div class="product-left-hover-overlay">
                                                    <ul class="left-over-buttons">
                                                        <li><a href="javascript:void(0);" class="d-inline-flex circle align-items-center justify-content-center"><i class="fas fa-expand-arrows-alt position-absolute"></i></a></li>
                                                        <li><a href="javascript:void(0);" class="d-inline-flex circle align-items-center justify-content-center snackbar-wishlist"><i class="far fa-heart position-absolute"></i></a></li>
                                                        <li><a href="javascript:void(0);" class="d-inline-flex circle align-items-center justify-content-center snackbar-addcart"><i class="fas fa-shopping-basket position-absolute"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer b-0 p-0 pt-2 bg-white d-flex align-items-start justify-content-between">
                                            <div class="text-left">
                                                <div class="text-left">
                                                    {{-- <div class="star-rating align-items-center d-flex justify-content-left mb-1 p-0">
                                                        <i class="fas fa-star filled"></i>
                                                        <i class="fas fa-star filled"></i>
                                                        <i class="fas fa-star filled"></i>
                                                        <i class="fas fa-star filled"></i>
                                                        <i class="fas fa-star"></i>
                                                        <span class="small">(5 Reviews)</span>
                                                    </div> --}}
                                                    <h5 class="fs-md mb-0 lh-1 mb-1"><a href="shop-single-v1.html">{{$value->name}}</a></h5>


                                                    <div class="elis_rty"><span class="ft-bold text-dark fs-sm">{{$value->price}}vnđ</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>



                                @foreach ($categories as $category)
                                <div class="tab-pane fade" id="{{$category->description}}" role="tabpanel" aria-labelledby="{{ $category->description }}-tab">
                                    <div class="tab_product">
                                        <div class="row rows-products">

                                            <!-- Single -->
                                @foreach ($category->productHome as $product)
                                <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                                    <div class="product_grid card b-0">
                                        <div class="badge bg-info text-white position-absolute ft-regular ab-left text-upper">Sale</div>
                                        <div class="card-body p-0">
                                            <div class="shop_thumb position-relative">
                                                <a class="card-img-top d-block overflow-hidden" href="{{ route('detail.show', $product->id) }}"><img class="card-img-top" src="{{Storage::url($product->image)}}" alt="..."></a>
                                                <div class="product-left-hover-overlay">
                                                    <ul class="left-over-buttons">
                                                        <li><a href="javascript:void(0);" class="d-inline-flex circle align-items-center justify-content-center"><i class="fas fa-expand-arrows-alt position-absolute"></i></a></li>
                                                        <li><a href="javascript:void(0);" class="d-inline-flex circle align-items-center justify-content-center snackbar-wishlist"><i class="far fa-heart position-absolute"></i></a></li>
                                                        <li><a href="javascript:void(0);" class="d-inline-flex circle align-items-center justify-content-center snackbar-addcart"><i class="fas fa-shopping-basket position-absolute"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer b-0 p-0 pt-2 bg-white d-flex align-items-start justify-content-between">
                                            <div class="text-left">
                                                <div class="text-left">
                                                    {{-- <div class="star-rating align-items-center d-flex justify-content-left mb-1 p-0">
                                                        <i class="fas fa-star filled"></i>
                                                        <i class="fas fa-star filled"></i>
                                                        <i class="fas fa-star filled"></i>
                                                        <i class="fas fa-star filled"></i>
                                                        <i class="fas fa-star"></i>
                                                        <span class="small">(5 Reviews)</span>
                                                    </div> --}}
                                                    <h5 class="fs-md mb-0 lh-1 mb-1"><a href="{{ route('detail.show', $product->id) }}">{{$product->name}}</a></h5>
                                                    <div class="elis_rty"><span class="ft-bold text-dark fs-sm">{{$product->discount}}vnđ - {{$product->price}}vnđ</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach


                </div>

            </div>
        </div>

    </div>
</section>
<!-- ======================= Products List ======================== -->

<!-- ======================= Product List ======================== -->
<section class="middle gray">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="sec_title position-relative text-center">
                    <h2 class="off_title">Trendy Products</h2>
                    <h3 class="ft-bold pt-3">Sản phẩm thịnh hành</h3>
                </div>
            </div>
        </div>

        <!-- row -->
        <div class="row align-items-center rows-products">

            @foreach ($trendingProducts as $trending)


            <!-- Single -->
            <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                <div class="product_grid card b-0">
                    <div class="badge bg-success text-white position-absolute ft-regular ab-left text-upper"></div>
                    <div class="card-body p-0">
                        <div class="shop_thumb position-relative">
                            <a class="card-img-top d-block overflow-hidden" href="{{ route('detail.show',$trending->id)}}"><img class="card-img-top" src="{{Storage::url($trending->image)}}" alt="..."></a>
                            <div class="product-hover-overlay bg-dark d-flex align-items-center justify-content-center">
                                <div class="edlio"><a href="{{ route('detail.show',$trending->id)}}" class="text-white fs-sm ft-medium"><i class="fas fa-eye mr-1"></i>Quick View</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer b-0 p-0 pt-2">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="text-left">
                                {{-- @foreach ($trending->variants as $color)
                                <div class="form-check form-option form-check-inline mb-1">
                                    <input class="form-check-input" type="radio" name="color1" id="white" checked="">
                                    <label class="form-option-label small rounded-circle" for="white" style="background-color: {{$color->color->name}};">
                                        {{$color->color->name}}
                                    </label> --}}
                                    {{-- <label class="color-radio" style="background-color: {{$color->name}};"></label> --}}
                                {{-- </div>
                                @endforeach --}}
                                <div class="form-check form-option form-check-inline mb-1">
                                    Lượt xem : {{$trending->views}}
                                </div>
                            </div>
                            <div class="text-right">
                                <button class="btn auto btn_love snackbar-wishlist"><i class="far fa-heart"></i></button>
                            </div>
                        </div>
                        <div class="text-left">
                            <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="{{ route('detail.show',$trending->id)}}">{{$trending->name}}</a></h5>
                            <div class="elis_rty"><span class="ft-bold text-dark fs-sm">{{$trending->price}} vnđ</span></div>
                        </div>
                    </div>
                </div>

            </div>

            @endforeach

            {{-- {{ $trendingProducts->links() }} --}}
        </div>
        {{ $trendingProducts->links() }}
        <!-- row -->



    </div>
</section>
<!-- ======================= Product List ======================== -->

<!-- ======================= Blog Start ============================ -->
<section class="space min">

</section>
<!-- ======================= Blog Start ============================ -->

<!-- ======================= Instagram Start ============================ -->
<section class="p-0">
    <div class="container-fluid p-0">

        <div class="row no-gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="sec_title position-relative text-center">
                    <h2 class="off_title">Instagram Gallery</h2>
                    <span class="fs-lg ft-bold theme-cl pt-3">@mahak_71</span>
                    <h3 class="ft-bold lh-1">From Instagram</h3>
                </div>
            </div>
        </div>

        <div class="row no-gutters">

            <div class="col">
                <div class="_insta_wrap">
                    <div class="_insta_thumb">
                        <a href="javascript:void(0);" class="d-block"><img src="assets/img/i-1.png" class="img-fluid" alt="" /></a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="_insta_wrap">
                    <div class="_insta_thumb">
                        <a href="javascript:void(0);" class="d-block"><img src="assets/img/i-2.png" class="img-fluid" alt="" /></a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="_insta_wrap">
                    <div class="_insta_thumb">
                        <a href="javascript:void(0);" class="d-block"><img src="assets/img/i-3.png" class="img-fluid" alt="" /></a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="_insta_wrap">
                    <div class="_insta_thumb">
                        <a href="javascript:void(0);" class="d-block"><img src="assets/img/i-7.png" class="img-fluid" alt="" /></a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="_insta_wrap">
                    <div class="_insta_thumb">
                        <a href="javascript:void(0);" class="d-block"><img src="assets/img/i-8.png" class="img-fluid" alt="" /></a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="_insta_wrap">
                    <div class="_insta_thumb">
                        <a href="javascript:void(0);" class="d-block"><img src="assets/img/i-4.png" class="img-fluid" alt="" /></a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="_insta_wrap">
                    <div class="_insta_thumb">
                        <a href="javascript:void(0);" class="d-block"><img src="assets/img/i-5.png" class="img-fluid" alt="" /></a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="_insta_wrap">
                    <div class="_insta_thumb">
                        <a href="javascript:void(0);" class="d-block"><img src="assets/img/i-6.png" class="img-fluid" alt="" /></a>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>
<!-- ======================= Instagram Start ============================ -->

<!-- ============================= Customer Features =============================== -->
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
@endsection
