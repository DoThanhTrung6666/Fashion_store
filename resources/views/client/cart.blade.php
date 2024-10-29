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
                        <li class="breadcrumb-item"><a href="#">Support</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- ======================= Top Breadcrubms ======================== -->

<!-- ======================= Product Detail ======================== -->
<section class="middle">
    <div class="container">

        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="text-center d-block mb-5">
                    <h2>Shopping Cart</h2>
                </div>
            </div>
        </div>

{{-- xử lí xoá nhiều bên ngoài if  --}}

@if($cart && $cart->cartItems->count()>0)
        <div class="row justify-content-between">
            <div class="col-12 col-lg-7 col-md-12">
                <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x mb-4">

                @foreach ($cart->cartItems as $item)
                <li class="list-group-item">
                    <div class="row align-items-center">

                        <div class="col-1">
                            <input type="checkbox" name="cart_item_ids[]" value="{{$item->id}}">
                        </div>
                        <div class="col-3">
                            <!-- Image -->
                            <a href="product.html"><img src="{{Storage::url($item->productVariant->product->image)}}" alt="..." class="img-fluid"></a>
                        </div>
                        <div class="col d-flex align-items-center justify-content-between">
                            <div class="cart_single_caption pl-2">
                                <h4 class="product_title fs-md ft-medium mb-1 lh-1">{{$item->productVariant->product->name}}</h4>
                                <p class="mb-1 lh-1"><span class="text-dark">Size: {{$item->productVariant->size->name}}</span></p>
                                <p class="mb-1 lh-1"><span class="text-dark">Color: <label class="form-option-label small rounded-circle" for="white" style="background-color: {{$item->productVariant->color->name}};"></label></span></p>

                                <h4 class="fs-md ft-medium mb-3 lh-1">{{$item->productVariant->price}}</h4>
                                {{-- <select class="mb-2 custom-select w-auto">
                                  <option value="1" selected="">{{$item->quanity}}</option>
                                </select> --}}
                                <input type="number" class="quantity-input" name="quantity" value="{{ $item->quantity }}" min="1" style="width: 60px;">
                            </div>
                            <div class="fls_last">
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="close_slide gray"><i class="ti-close"></i></button>
                                </form>

                            </div>
                        </div>
                    </div>
                </li>
                @endforeach


                </ul>

                <div class="row align-items-end justify-content-between mb-10 mb-md-0">
                    <div class="col-12 col-md-7">
                        <!-- Coupon -->
                        <form class="mb-7 mb-md-0">
                            <label class="fs-sm ft-medium text-dark">Coupon code:</label>
                            <div class="row form-row">
                                <div class="col">
                                  <input class="form-control" type="text" placeholder="Enter coupon code*">
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-dark" type="submit">Apply</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-12 col-md-auto mfliud">
                        <button class="btn stretched-link borders">Update Cart</button>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-12 col-lg-4">
                <div class="card mb-4 gray mfliud">
                  <div class="card-body">
                    <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x">
                      <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                        <span>Subtotal</span> <span class="ml-auto text-dark ft-medium">{{$totalPrice}}</span>
                      </li>
                      <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                        <span>Tax</span> <span class="ml-auto text-dark ft-medium">$10.10</span>
                      </li>
                      <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                        <span>Total</span> <span class="ml-auto text-dark ft-medium">$108.22</span>
                      </li>
                      <li class="list-group-item fs-sm text-center">
                        Shipping cost calculated at Checkout *
                      </li>
                    </ul>
                  </div>
                </div>

                <a class="btn btn-block btn-dark mb-3" href="{{route('checkout')}}">Proceed to Checkout</a>

                <a class="btn-link text-dark ft-medium" href="shop.html">
                  <i class="ti-back-left mr-2"></i> Continue Shopping
                </a>
            </div>

        </div>
        <button type="submit" class="btn btn-danger">Xóa các sản phẩm đã chọn</button>

@else
    <p>Giỏ hàng của bạn trống</p>
@endif

    </div>
</section>
<!-- ======================= Product Detail End ======================== -->
@endsection
