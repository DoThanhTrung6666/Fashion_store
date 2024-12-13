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
                            {{-- <li class="breadcrumb-item"><a href="#">Support</a></li> --}}
                            <li class="breadcrumb-item active" aria-current="page">Kiểm tra thông tin</li>
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
                        <h2>Kiểm tra thông tin</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-between">
                <div class="col-12 col-lg-7 col-md-12">
                    <form action="" id="paymentForm" method="POST">
                        @csrf
                        <h5 class="mb-4 ft-medium">Thông tin cá nhân</h5>
                        <div class="row mb-2">

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label class="text-dark">Họ và tên</label>
                                    <input type="text" class="form-control" placeholder="Họ và tên" name="name_order"
                                        value="@if ($user !== null) {{ $user->name }} @endif" />
                                    @error('name_order')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label class="text-dark">Email *</label>
                                    <input type="email" class="form-control" placeholder="Email"
                                        value="@if ($user !== null) {{ $user->email }} @endif" />
                                </div>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label class="text-dark">Địa chỉ</label>
                                    <input type="text" class="form-control" name="address_order"
                                        placeholder="Nhập địa chỉ của bạn"
                                        value="@if ($user !== null) {{ $user->address }} @endif" />
                                    @error('address_order')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label class="text-dark">Số điện thoại *</label>
                                    <input type="text" class="form-control" name="phone_order"
                                        placeholder="Mobile Number"
                                        value="@if ($user !== null) {{ $user->phone }} @endif" />
                                    @error('phone_order')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label class="text-dark">Ghi chú</label>
                                    <textarea class="form-control ht-50" name="content_order"></textarea>
                                </div>
                            </div>

                        </div>

                        {{-- <div class="row mb-4">
                            <div class="col-12 d-block">
                                <input id="createaccount" class="checkbox-custom" name="createaccount" type="checkbox">
                                <label for="createaccount" class="checkbox-custom-label">Create An Account?</label>
                            </div>
                        </div> --}}


                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="payment-options">
                                    <!-- Thanh toán khi nhận hàng -->
                                    <label class="radio-dot">
                                        <input type="radio" name="payment_method" value="cod" checked
                                            onchange="updateFormAction(this)">
                                        <span class="custom-dot"></span>
                                        Thanh toán khi nhận hàng
                                    </label>

                                    <!-- Thanh toán trực tuyến -->
                                    <label class="radio-dot">
                                        <input type="radio" name="payment_method" value="vnpay"
                                            onchange="updateFormAction(this)">
                                        <span class="custom-dot"></span>
                                        Thanh toán trực tuyến (VnPay)
                                    </label>
                                </div>
                            </div>
                        </div>




                        <script>
                            function updateFormAction(radioInput) {
                                const form = document.getElementById("paymentForm");

                                // Lấy giá trị từ radio button và thay đổi action
                                switch (radioInput.value) {
                                    case "cod":
                                        form.action = "{{ route('checkout.order') }}"; // Route xử lý COD
                                        break;
                                    case "vnpay":
                                        form.action = "{{ route('vnpay') }}"; // Route xử lý VnPay
                                        break;
                                    default:
                                        form.action = ""; // Hoặc để trống nếu không xác định
                                }
                            }

                            // Gọi hàm khi trang tải để thiết lập giá trị mặc định
                            document.addEventListener("DOMContentLoaded", function() {
                                const defaultRadio = document.querySelector('input[name="payment_method"]:checked');
                                if (defaultRadio) {
                                    updateFormAction(defaultRadio);
                                }
                            });
                        </script>
                        <style>
                            .payment-options {
                                display: flex;
                                flex-direction: column;
                                gap: 15px;
                            }

                            .radio-dot {
                                display: flex;
                                align-items: center;
                                cursor: pointer;
                                font-size: 16px;
                                color: #333;
                            }

                            .radio-dot input[type="radio"] {
                                display: none;
                                /* Ẩn radio mặc định */
                            }

                            .radio-dot .custom-dot {
                                width: 16px;
                                height: 16px;
                                border: 2px solid #ccc;
                                border-radius: 50%;
                                margin-right: 10px;
                                position: relative;
                                transition: border-color 0.3s ease;
                            }

                            .radio-dot input[type="radio"]:checked+.custom-dot {
                                border-color: #007bff;
                                background-color: #007bff;
                            }

                            .radio-dot input[type="radio"]:checked+.custom-dot::after {
                                content: "";
                                width: 8px;
                                height: 8px;
                                background: white;
                                border-radius: 50%;
                                position: absolute;
                                top: 50%;
                                left: 50%;
                                transform: translate(-50%, -50%);
                            }
                        </style>

                </div>

                <!-- Sidebar -->

                <div class="col-12 col-lg-4 col-md-12">
                    <div class="d-block mb-3">
                        <h5 class="mb-4">Chi tiết đơn hàng</h5>
                        <span style="font-size: 15px">
                            @if(session('error'))
                                <p style="color: red">{{session('error')}}</p>
                            @endif
                        </span>
                        <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x mb-4">
                            @if (Auth::user())
                                @if (!empty($cartItemsWithSaleInfo) && count($cartItemsWithSaleInfo) > 0)
                                    @foreach ($cartItemsWithSaleInfo as $item)
                                        <input type="hidden" name="selectedCartItemIds[]"
                                            value="{{ $item['cartItem']->id }}">
                                        <li class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col-3">
                                                    <!-- Image -->
                                                    <a href="#"><img
                                                            src="{{ Storage::url($item['cartItem']->productVariant->product->image) }}"
                                                            alt="..." class="img-fluid"></a>
                                                </div>
                                                <div class="col d-flex align-items-center">
                                                    <div class="cart_single_caption pl-2">
                                                        <h4 class="product_title fs-md ft-medium mb-1 lh-1">
                                                            {{ $item['cartItem']->productVariant->product->name }}</h4>
                                                        <p class="mb-1 lh-1"><span class="text-dark">Size:
                                                                {{ $item['cartItem']->productVariant->size->name }}</span>
                                                        </p>
                                                        <p class="mb-3 lh-1"><span class="text-dark">Color:
                                                                {{ $item['cartItem']->productVariant->color->name }}</span>
                                                        </p>
                                                        <h4 class="fs-md ft-medium mb-3 lh-1">
                                                            {{ $item['cartItem']->productVariant->price }}</h4>
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
                                @if (Auth::user())
                                    @if (!empty($cartItemsWithSaleInfo) && count($cartItemsWithSaleInfo) > 0)
                                        <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                                            <span>Subtotal</span> <span
                                                class="ml-auto text-dark ft-medium">{{ number_format($totalPrice) }}</span>
                                        </li>
                                        <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                                            <span>Giảm giá voucher</span> <span
                                                class="ml-auto text-dark ft-medium">{{ number_format(Session::get('voucher_discount')['discount_amount']) }}
                                                </span>
                                        </li>
                                        <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                                            <span>Phí vận chuyển</span> <span class="ml-auto text-dark ft-medium">30,000
                                                </span>
                                        </li>
                                        @php
                                            $discountAmount = session()->has('voucher_discount')
                                                ? session()->get('voucher_discount')['discount_amount']
                                                : 0;
                                        @endphp
                                        <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                                            <span>Total</span> <span
                                                class="ml-auto text-dark ft-medium">{{ number_format($totalPrice - $discountAmount + 30000) }}</span>
                                        </li>
                                    @else
                                        <span>Subtotal</span> <span class="ml-auto text-dark ft-medium">0</span>
                                        <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                                            <span>Phí vận chuyển</span> <span class="ml-auto text-dark ft-medium">30.000
                                                vnđ</span>
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
                                        <span>Phí vận chuyển</span> <span class="ml-auto text-dark ft-medium">30.000
                                            vnđ</span>
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
                <li class="list-group-item d-flex text-dark fs-sm ft-regular"
                    style="margin-left: 15px; position: relative;">
                    <form method="POST" action="{{ route('applyVoucher') }}" class="d-flex w-100">
                        <input type="hidden" name="selectedCartItemIds[]" value="{{ $item['cartItem']->id }}">
                        @csrf
                        <input type="text" name="voucher" class="form-control form-control-sm me-2"
                            placeholder="Nhập mã voucher">
                        <button type="submit" class="btn btn-sm btn-primary" style="margin-left: 10px">Áp
                            dụng</button>
                    </form>
                </li>
                @if (session('success'))
                    <script>
                        alert('{{ session('success') }}');
                    </script>
                @endif

                @if (session('error'))
                    <script>
                        alert('{{ session('error') }}');
                    </script>
                @endif



            </div>

        </div>
    </section>
@endsection
