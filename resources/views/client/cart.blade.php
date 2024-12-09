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
            @if (session('error'))
                <div>
                    {{ session('error') }}
                </div>
            @endif
            @if ($cart)
                <div class="row justify-content-between">
                    <div class="col-12 col-lg-7 col-md-12">
                        <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x mb-4">

                            @foreach ($cartItemsWithSaleInfo as $item)
                                <li class="list-group-item">
                                    <div class="row align-items-center">

                                        <div class="col-1">
                                            <input type="checkbox" name="cart_item_ids[]" value="">
                                        </div>
                                        <div class="col-3">
                                            <!-- Image -->
                                            <a href="product.html"><img
                                                    src="{{ Storage::url($item['cartItem']->productVariant->image_variant) }}"
                                                    alt="..." class="img-fluid"></a>
                                        </div>
                                        <div class="col d-flex align-items-center justify-content-between">
                                            <div class="cart_single_caption pl-2">
                                                <h4 class="product_title fs-md ft-medium mb-1 lh-1">
                                                    {{ $item['cartItem']->productVariant->product->name }}</h4>
                                                <p class="mb-1 lh-1"><span class="text-dark">Size:
                                                        {{ $item['cartItem']->productVariant->size->name }}</span></p>
                                                <p class="mb-1 lh-1"><span class="text-dark">Color:
                                                        {{ $item['cartItem']->productVariant->color->name }}</span></p>


                                                @if ($item['isOnFlashSale'])
                                                    <h3 style="color: red">Đang diễn ra chương trình flash-sale</h3>
                                                    <div class="elis_rty">Giá gốc :<span
                                                            class="ft-medium text-muted line-through fs-md mr-2">{{ $item['cartItem']->productVariant->product->price * $item['cartItem']->quantity }}</span>vnđ<br>Giá
                                                        sau khi giảm:<span
                                                            class="ft-bold theme-cl fs-lg">{{ $item['finalPrice'] * $item['cartItem']->quantity }}</span>
                                                        vnđ</div>
                                                @else
                                                    <h4 class="fs-md ft-medium mb-3 lh-1">
                                                        {{ $item['cartItem']->productVariant->product->price }}vnđ</h4>
                                                @endif

                                                {{-- <select class="mb-2 custom-select w-auto">
                                  <option value="1" selected="">{{$item->quanity}}</option>
                                </select> --}}
                                                <input type="number" class="quantity-input" name="quantity"
                                                    value="{{ $item['cartItem']->quantity }}" min="1"
                                                    style="width: 60px;">
                                            </div>
                                            <div class="fls_last">
                                                <form action="{{ route('cart.remove', $item['cartItem']->id) }}"
                                                    method="POST">
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

                    </div>

                    <div class="col-12 col-md-12 col-lg-4">
                        <div class="card mb-4 gray mfliud">
                            <div class="card-body">
                                <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x">

                                    <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                                        <span>Tổng tiền : </span> <span class="ml-auto text-dark ft-medium">
                                            {{ $totalAmount }}

                                        </span>
                                    </li>
                                    <li class="list-group-item fs-sm text-center">
                                        Chi phí vận chuyển được tính khi Thanh toán *
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <a class="btn btn-block btn-dark mb-3" href="{{ route('checkout') }}">Tiến hành thanh toán</a>

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
