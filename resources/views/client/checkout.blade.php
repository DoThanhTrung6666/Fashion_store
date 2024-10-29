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
                        <li class="breadcrumb-item active" aria-current="page">Checkout</li>
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
                    <h2>Checkout</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-between">
            <div class="col-12 col-lg-7 col-md-12">
                <form action="{{route('checkout.order')}}" method="POST">
                    @csrf
                    <h5 class="mb-4 ft-medium">Billing Details</h5>
                    <div class="row mb-2">

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label class="text-dark">Họ và tên</label>
                                <input type="text" class="form-control" placeholder="Họ và tên"  value="{{$user->name}}"/>
                            </div>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label class="text-dark">Email *</label>
                                <input type="email" class="form-control" placeholder="Email" value="{{$user->email}}"/>
                            </div>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label class="text-dark">Địa chỉ</label>
                                <input type="text" class="form-control" placeholder="Nhập địa chỉ của bạn" />
                            </div>
                        </div>


                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label class="text-dark">Mobile Number *</label>
                                <input type="text" class="form-control" placeholder="Mobile Number" />
                            </div>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label class="text-dark">Ghi chú</label>
                                <textarea class="form-control ht-50"></textarea>
                            </div>
                        </div>

                    </div>

                    <div class="row mb-4">
                        <div class="col-12 d-block">
                            <input id="createaccount" class="checkbox-custom" name="createaccount" type="checkbox">
                            <label for="createaccount" class="checkbox-custom-label">Create An Account?</label>
                        </div>
                    </div>

                    <h5 class="mb-4 ft-medium">Payments</h5>
                    <div class="row mb-4">
                        <div class="col-12 col-lg-12 col-xl-12 col-md-12">
                            <div class="panel-group pay_opy980" id="payaccordion">

                                <!-- Pay By Paypal -->
                                <div class="panel panel-default border">
                                    <div class="panel-heading" id="pay">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" role="button" data-parent="#payaccordion" href="#payPal" aria-expanded="true"  aria-controls="payPal" class="">PayPal<img src="assets/img/paypal.html" class="img-fluid" alt=""></a>
                                        </h4>
                                    </div>
                                    <div id="payPal" class="panel-collapse collapse show" aria-labelledby="pay" data-parent="#payaccordion">
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label class="text-dark">PayPal Email</label>
                                                <input type="text" class="form-control simple" placeholder="paypal@gmail.com">
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-dark btm-md full-width">Pay 400.00 USD</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


            </div>

            <!-- Sidebar -->

            <div class="col-12 col-lg-4 col-md-12">
                <div class="d-block mb-3">
                    <h5 class="mb-4">Order Items (3)</h5>
                    <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x mb-4">
                        @if($cart && $cart->cartItems->count()>0)
                        @foreach ($cart->cartItems as $item )
                        <li class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col-3">
                                    <!-- Image -->
                                    <a href="product.html"><img src="{{Storage::url($item->productVariant->product->image)}}" alt="..." class="img-fluid"></a>
                                </div>
                                <div class="col d-flex align-items-center">
                                    <div class="cart_single_caption pl-2">
                                        <h4 class="product_title fs-md ft-medium mb-1 lh-1">{{$item->productVariant->product->name}}</h4>
                                        <p class="mb-1 lh-1"><span class="text-dark">Size: {{$item->productVariant->size->name}}</span></p>
                                        <p class="mb-3 lh-1"><span class="text-dark">Color: {{$item->productVariant->color->name}}</span></p>
                                        <h4 class="fs-md ft-medium mb-3 lh-1">{{$item->productVariant->price}}</h4>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                        @else
                            <p>Chưa có sản phẩm</p>
                        @endif

                    </ul>
                </div>

                <div class="card mb-4 gray">
                  <div class="card-body">
                    <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x">
                        @if($cart && $cart->cartItems->count()>0)
                      <li class="list-group-item d-flex text-dark fs-sm ft-regular">

                        <span>Subtotal</span> <span class="ml-auto text-dark ft-medium">{{$totalPrice}}</span>
                      </li>
                      @else
                      <span>Subtotal</span> <span class="ml-auto text-dark ft-medium">0</span>
                      @endif
                      <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                        <span>Tax</span> <span class="ml-auto text-dark ft-medium">$10.10</span>
                      </li>
                      <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                        <span>Total</span> <span class="ml-auto text-dark ft-medium">Chưa có tổng</span>
                      </li>
                      <li class="list-group-item fs-sm text-center">
                        Shipping cost calculated at Checkout *
                      </li>


                    </ul>
                  </div>
                </div>

                <button type="submit" class="btn btn-dark btm-md full-width">Place Your Order</button>
            </div>

        </form>
        </div>

    </div>
</section>
@endsection
