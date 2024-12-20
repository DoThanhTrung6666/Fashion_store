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
                            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                            <li class="breadcrumb-item"><a href="#">Chi tiết</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Giỏ hàng</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ======================= Top Breadcrubms ======================== -->

    <!-- ======================= Product Detail ======================== -->
    <section style="margin-top: 5px">
        <div class="container">

            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="text-center d-block mb-5">
                        <h2>Giỏ hàng của tôi</h2>
                    </div>
                </div>
            </div>

            {{-- xử lí xoá nhiều bên ngoài if  --}}

            @if ($cart)
                <div class="row justify-content-between">
                    <div class="col-12 col-lg-7 col-md-12">
                        <form method="POST" action="{{ route('cart.proceedToCheckout') }}">
                            @csrf
                            <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x mb-4">

                                @foreach ($cartItemsWithSaleInfo as $item)
                                    <li class="list-group-item">
                                        <div class="row align-items-center">

                                            <div class="col-1">
                                                <input type="checkbox" name="cart_item_ids[]"
                                                    value="{{ $item['cartItem']->id }}">

                                            </div>
                                            <div class="col-3">
                                                <!-- Image -->
                                                <a href="#"><img width="50px"
                                                        src="{{ Storage::url($item['cartItem']->productVariant->image_variant) }}"
                                                        alt="..." class="img-fluid"></a>
                                            </div>
                                            <div class="col d-flex align-items-center justify-content-between">
                                                <div class="cart_single_caption pl-2">
                                                    <h4 class="product_title fs-md ft-medium mb-1 lh-1">
                                                        {{ $item['cartItem']->productVariant->product->name }}</h4>
                                                    <div style="display:flex">
                                                        <p class="mb-1 lh-1"><span class="text-dark">Kích cỡ:
                                                            {{ $item['cartItem']->productVariant->size->name }}</span></p>
                                                        <p class="mb-1 lh-1 ml-2" ><span class="text-dark">Màu sắc:
                                                            {{ $item['cartItem']->productVariant->color->name }}</span></p>
                                                    </div>
                                                    @if ($item['isOnFlashSale'])
                                                        <h5 style="color: red">Đang diễn ra chương trình flash-sale</h5>
                                                        <div class="elis_rty">
                                                            Giá gốc : <span class="line-through">{{number_format( $item['cartItem']->productVariant->product->price * $item['cartItem']->quantity )}}</span>đ<br>
                                                            Giá ưu đãi : <span style="color:red">{{number_format( $item['finalPrice'] * $item['cartItem']->quantity) }}đ</span>
                                                        </div>
                                                    @else
                                                        <h4 class="fs-md ft-medium mb-3 lh-1">
                                                            {{ number_format($item['cartItem']->productVariant->product->price* $item['cartItem']->quantity) }}
                                                            VNĐ</h4>
                                                    @endif

                                                    {{-- <select class="mb-2 custom-select w-auto">
                                  <option value="1" selected="">{{$item->quanity}}</option>
                                </select> --}}
                                                    {{-- <input type="number" class="quantity-input" name="quantity"
                                                        value="{{ $item['cartItem']->quantity }}" min="1"
                                                        style="width: 60px;"> --}}
                                                        <div style="display: flex; align-items: center;">
                                                            {{-- Nút trừ số lượng --}}
                                                            <a href="javascript:void(0);" class="quantity-button decrease"
                                                               onclick="event.preventDefault(); document.getElementById('decrease-form-{{ $item['cartItem']->id }}').submit();">-</a>

                                                            {{-- Hiển thị số lượng --}}
                                                            <input type="number" class="quantity-input text-center" name="quantity"
                                                                   value="{{ $item['cartItem']->quantity }}" readonly style="width: 60px;">

                                                            {{-- Nút tăng số lượng --}}
                                                            <a href="javascript:void(0);" class="quantity-button increase"
                                                               onclick="event.preventDefault(); document.getElementById('increase-form-{{ $item['cartItem']->id }}').submit();">+</a>
                                                        </div>
                                                </div>
                                                <div class="fls_last">
                                                    <a href="javascript:void(0);" class="close_slide gray"
                                                        onclick="event.preventDefault(); document.getElementById('remove-form-{{ $item['cartItem']->id }}').submit();">
                                                        <i class="ti-close"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                    </div>

                    <div class="col-12 col-md-12 col-lg-4">
                        <span style="color: red">
                            @if (session('error'))
                                <div>
                                    {{ session('error') }}
                                </div>
                            @endif
                        </span>
                        <div class="card mb-4 gray mfliud">
                            <div class="card-body">
                                <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x">

                                    <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                                        <span>Tổng tiền : </span> <span class="ml-auto text-dark ft-medium">
                                            {{ number_format($totalAmount) }} VNĐ

                                        </span>
                                    </li>
                                    <li class="list-group-item fs-sm text-center">
                                        Chi phí vận chuyển được tính khi Thanh toán *
                                    </li>
                                </ul>
                            </div>
                        </div>

                        {{-- <a class="btn btn-block btn-dark mb-3" href="{{route('cart.proceedToCheckout')}}">Tiến hành thanh toán</a> --}}
                        <button type="submit" class="btn btn-block btn-dark mb-3">Tiến hành thanh toán</button>
                        </form>

                        @foreach ($cartItemsWithSaleInfo as $item)
                            <form id="remove-form-{{ $item['cartItem']->id }}"
                                action="{{ route('cart.remove', $item['cartItem']->id) }}" method="POST"
                                style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        @endforeach
                        {{-- form xoá  --}}
                        @foreach ($cartItemsWithSaleInfo as $item)
                            {{-- Form giảm số lượng --}}
                            <form id="decrease-form-{{ $item['cartItem']->id }}"
                                action="{{ route('cart.decrease', $item['cartItem']->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('PUT')
                                {{-- <input type="hidden" name="quantity" value="{{ $item['cartItem']->quantity - 1 }}"> --}}
                            </form>

                            {{-- Form tăng số lượng --}}
                            <form id="increase-form-{{ $item['cartItem']->id }}"
                                action="{{ route('cart.increase', $item['cartItem']->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('PUT')
                                {{-- <input type="hidden" name="quantity" value="{{ $item['cartItem']->quantity + 1 }}"> --}}
                            </form>
                        @endforeach
                        {{-- form cập nhật số lượng  --}}
                        <a class="btn-link text-dark ft-medium" href="{{route('home')}}">
                            <i class="ti-back-left mr-2"></i> Tiếp tục đặt hàng
                        </a>
                    </div>

                </div>
                {{-- <button type="submit" class="btn btn-danger">Xóa các sản phẩm đã chọn</button> --}}
            @else
                <p>Giỏ hàng của bạn trống</p>
            @endif

        </div>
    </section>
    <!-- ======================= Product Detail End ======================== -->
@endsection
<style>
    /* Thiết lập giao diện cho nút tăng/giảm */
.quantity-button {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    width: 30px;
    height: 30px;
    background-color: #f8f9fa;
    border: 1px solid #ced4da;
    border-radius: 5px;
    color: #495057;
    font-size: 16px;
    font-weight: bold;
    text-decoration: none;
    transition: all 0.2s ease-in-out;
    cursor: pointer;
}

/* Hiệu ứng khi rê chuột vào */
.quantity-button:hover {
    background-color: #e2e6ea;
    border-color: #adb5bd;
    color: #212529;
}

/* Thêm khoảng cách giữa các nút */
.quantity-button.decrease {
    /* margin-right: 5px; */
}

.quantity-button.increase {
    /* margin-left: 5px; */
}

/* Giao diện của input số lượng */
.quantity-input {
    border: 1px solid #ced4da;
    border-radius: 5px;
    width: 50px;
    height: 30px;
    text-align: center;
    font-size: 14px;
    font-weight: bold;
    color: #495057;
    background-color: #fff;
    padding: 0;
    /* margin: 0 5px; */
    cursor: not-allowed;
}

</style>
