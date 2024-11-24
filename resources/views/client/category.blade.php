@extends('client.index')

@section('content1')
<div class="tab-content" id="myTabContent">

    <!-- All Content -->
    <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
            <div class="row rows-products">

                <!-- Single -->
                @foreach ($productsByCategory as $value)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                        <div class="product_grid card b-0">
                            <div
                                class="badge bg-info text-white position-absolute ft-regular ab-left text-upper">
                                Sale</div>
                            <div class="card-body p-0">
                                <div class="shop_thumb position-relative">
                                    <a class="card-img-top d-block overflow-hidden"
                                        href="shop-single-v1.html"><img class="card-img-top"
                                            src="{{ Storage::url($value->image) }}"
                                            alt="..."></a>
                                    <div class="product-left-hover-overlay">
                                        <ul class="left-over-buttons">
                                            <li><a href="javascript:void(0);"
                                                    class="d-inline-flex circle align-items-center justify-content-center"><i
                                                        class="fas fa-expand-arrows-alt position-absolute"></i></a>
                                            </li>
                                            <li><a href="javascript:void(0);"
                                                    class="d-inline-flex circle align-items-center justify-content-center snackbar-wishlist"><i
                                                        class="far fa-heart position-absolute"></i></a>
                                            </li>
                                            <li><a href="javascript:void(0);"
                                                    class="d-inline-flex circle align-items-center justify-content-center snackbar-addcart"><i
                                                        class="fas fa-shopping-basket position-absolute"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="card-footer b-0 p-0 pt-2 bg-white d-flex align-items-start justify-content-between">
                                <div class="text-left">
                                    <div class="text-left">
                                        <div
                                            class="star-rating align-items-center d-flex justify-content-left mb-1 p-0">
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star"></i>
                                            <span class="small">(5 Reviews)</span>
                                        </div>
                                        <h5 class="fs-md mb-0 lh-1 mb-1"><a
                                                href="">{{ $value->name }}</a></h5>
                                        <div class="elis_rty"><span
                                                class="ft-bold text-dark fs-sm">$99 - $129</span></div>
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
        <div class="tab-pane fade" id="{{ $category->description }}" role="tabpanel"
            aria-labelledby="{{ $category->description }}-tab">
            <div class="tab_product">
                <div class="row rows-products">

                    <!-- Single -->
                    @foreach ($category->productHome as $product)
                        <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                            <div class="product_grid card b-0">
                                <div
                                    class="badge bg-info text-white position-absolute ft-regular ab-left text-upper">
                                    Sale</div>
                                <div class="card-body p-0">
                                    <div class="shop_thumb position-relative">
                                        <a class="card-img-top d-block overflow-hidden"
                                            href="{{ route('detail.show', $product->id) }}"><img
                                                class="card-img-top"
                                                src="{{ Storage::url($product->image) }}"
                                                alt="..."></a>
                                        <div class="product-left-hover-overlay">
                                            <ul class="left-over-buttons">
                                                <li><a href="javascript:void(0);"
                                                        class="d-inline-flex circle align-items-center justify-content-center"><i
                                                            class="fas fa-expand-arrows-alt position-absolute"></i></a>
                                                </li>
                                                <li><a href="javascript:void(0);"
                                                        class="d-inline-flex circle align-items-center justify-content-center snackbar-wishlist"><i
                                                            class="far fa-heart position-absolute"></i></a>
                                                </li>
                                                <li><a href="javascript:void(0);"
                                                        class="d-inline-flex circle align-items-center justify-content-center snackbar-addcart"><i
                                                            class="fas fa-shopping-basket position-absolute"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="card-footer b-0 p-0 pt-2 bg-white d-flex align-items-start justify-content-between">
                                    <div class="text-left">
                                        <div class="text-left">
                                            <div
                                                class="star-rating align-items-center d-flex justify-content-left mb-1 p-0">
                                                <i class="fas fa-star filled"></i>
                                                <i class="fas fa-star filled"></i>
                                                <i class="fas fa-star filled"></i>
                                                <i class="fas fa-star filled"></i>
                                                <i class="fas fa-star"></i>
                                                <span class="small">(5 Reviews)</span>
                                            </div>
                                            <h5 class="fs-md mb-0 lh-1 mb-1"><a
                                                    href="{{ route('detail.show', $product->id) }}">{{ $product->name }}</a>
                                            </h5>
                                            <div class="elis_rty"><span
                                                    class="ft-bold text-dark fs-sm">{{ $product->discount }}vnđ
                                                    - {{ $product->price }}vnđ</span></div>
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
@endsection