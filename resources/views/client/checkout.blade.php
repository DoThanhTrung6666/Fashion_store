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
                                <input type="text" class="form-control" placeholder="Họ và tên"  value="@if($user !== null){{$user->name}} @endif"/>
                            </div>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label class="text-dark">Email *</label>
                                <input type="email" class="form-control" placeholder="Email" value="@if($user !== null){{$user->email}} @endif"/>
                            </div>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label class="text-dark">Địa chỉ</label>
                                <input type="text" class="form-control" placeholder="Nhập địa chỉ của bạn" value="@if($user !== null){{$user->address}} @endif" />
                            </div>
                        </div>


                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label class="text-dark">Mobile Number *</label>
                                <input type="text" class="form-control" placeholder="Mobile Number" value="@if($user !== null){{$user->phone}} @endif" />
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



            </div>

            <!-- Sidebar -->

            <div class="col-12 col-lg-4 col-md-12">
                <div class="d-block mb-3">
                    <h5 class="mb-4">Order Items (3)</h5>
                    <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x mb-4">
                        @if(Auth::user())
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
                        @endif
                    </ul>
                </div>

                <div class="card mb-4 gray">
                  <div class="card-body">
                    <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x">

                        {{-- tồn tại user  --}}
                        @if(Auth::user())
                        @if($cart && $cart->cartItems->count()>0)
                      <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                        <span>Subtotal</span> <span class="ml-auto text-dark ft-medium">{{$totalPrice}}</span>
                      </li>
                      <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                        <span>Phí vận chuyển</span> <span class="ml-auto text-dark ft-medium">30.000 vnđ</span>
                      </li>
                      <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                        <span>Total</span> <span class="ml-auto text-dark ft-medium">{{$totalPrice + 30000}}</span>
                      </li>
                      @else
                      <span>Subtotal</span> <span class="ml-auto text-dark ft-medium">0</span>
                      <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                        <span>Phí vận chuyển</span> <span class="ml-auto text-dark ft-medium">30.000 vnđ</span>
                      </li>
                      <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                        <span>Total</span> <span class="ml-auto text-dark ft-medium">0</span>
                      </li>
                      @endif

                      {{-- không tồn tại user --}}
                      @else
                      <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                        <span>Subtotal</span> <span class="ml-auto text-dark ft-medium">0</span>
                      </li>
                      <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                        <span>Phí vận chuyển</span> <span class="ml-auto text-dark ft-medium">30.000 vnđ</span>
                      </li>
                      <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                        <span>Total</span> <span class="ml-auto text-dark ft-medium"></span>
                      </li>
                      @endif

                      <li class="list-group-item fs-sm text-center">
                        Kiểm tra lại thông tin đặt hàng
                      </li>


                    </ul>
                  </div>
                </div>

                <button type="submit" class="btn btn-dark btm-md full-width">Tiến hành đặt hàng</button>
            </div>

        </form>
        </div>

    </div>
</section>
@endsection
