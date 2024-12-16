@extends('layout.client')

@section('content')
    <div class="gray py-3">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Đơn hàng của bạn</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

<section>
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="text-center d-block mb-5">
                    <h2>Đơn hàng của bạn</h2>
                </div>
            </div>
        </div>

        {{-- Tabs --}}
        <div class="tabs">
            <a href="?tab=all" class="tab {{ request('tab') == 'all' || !request('tab') ? 'active' : '' }}">Tất cả</a>
            <a href="?tab=pending" class="tab {{ request('tab') == 'pending' ? 'active' : '' }}">Chờ xác nhận</a>
            <a href="?tab=shipping" class="tab {{ request('tab') == 'shipping' ? 'active' : '' }}">Vận chuyển</a>
            <a href="?tab=delivery" class="tab {{ request('tab') == 'delivery' ? 'active' : '' }}">Chờ giao hàng</a>
            <a href="?tab=completed" class="tab {{ request('tab') == 'completed' ? 'active' : '' }}">Hoàn thành</a>
            <a href="?tab=cancelled" class="tab {{ request('tab') == 'cancelled' ? 'active' : '' }}">Đã hủy</a>
            <a href="?tab=return" class="tab {{ request('tab') == 'return' ? 'active' : '' }}">Trả hàng/Hoàn tiền</a>
        </div>

        <div class="search-bar">
            <form action="{{route('orders.search')}}" method="GET">
                @csrf
                <div style="display:flex">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Bạn có thể tìm kiếm theo ID đơn hàng hoặc Tên Sản phẩm">
                    <input type="submit" style="width:100px" value="Tìm kiếm">
                </div>
            </form>
        </div>

        {{-- Content --}}
        <div class="content" style="margin-top: 10px">
            {{-- tìm kiếm đơn hàng  --}}
            @if (request('search'))
                <h3>Kết quả tìm kiếm cho: "{{ request('search') }}"</h3>

            {{-- Hiển thị thong tin tìm kiếm --}}
            @foreach ($orders as $order)
                <div class="order-wrapper" style="margin-top: 20px">
                    <div class="order-card">
                        <div class="shop-info">
                            <span class="shop-name">Mã đơn hàng : #{{ $order->id }}</span>
                            <div class="shop-actions">
                                {{-- <button class="chat-btn">Chat</button>
                            <button class="view-shop-btn">Xem Shop</button> --}}
                                <span class="discounted-price">Ngày đặt hàng :
                                    {{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</span>
                            </div>
                        </div>

                        @foreach ($order->orderItems as $item)
                            <div class="order-info">
                                <img src="{{ Storage::url($item->productVariant->image_variant) }}" alt="Bag Image" class="product-image">
                                <div class="product-details">
                                    <p class="product-name">{{ $item->productVariant->product->name }}</p>
                                    <p class="product-variant">Phân loại hàng: Màu
                                        {{ $item->productVariant->color->name }} , Kích cỡ
                                        {{ $item->productVariant->size->name }}</p>
                                    <p class="product-quantity">Số lượng : {{ $item->quantity }}x</p>
                                </div>
                                @php
                                    // Lấy tất cả các Flash Sale Items của sản phẩm
                                    $flashSaleItems = $item->productVariant->product->flashSaleItems;

                                    // Kiểm tra nếu có Flash Sale và sản phẩm tham gia vào Flash Sale tại thời điểm mua hàng
                                    $flashSaleItem = $flashSaleItems->first(function($flashSale) use ($order) {
                                        return $flashSale->start_time <= $order->order_date && $flashSale->end_time >= $order->order_date;
                                    });

                                    // Lấy giá gốc của sản phẩm
                                    $originalPrice = $item->productVariant->product->price;

                                    // Lấy giá Flash Sale nếu có
                                    $flashSalePrice = $flashSaleItem ? $flashSaleItem->price : null;
                                @endphp

                                @if($flashSaleItem)
                                <div class="product-price">
                                    <span
                                        class="original-price">{{ number_format($flashSalePrice, 0, ',', '.') }}đ</span>
                                    <span
                                        class="discounted-price">{{ number_format($originalPrice, 0, ',', '.') }}đ
                                    </span>
                                </div>
                                @else
                                    <span
                                        class="discounted-price">{{ number_format($item->productVariant->product->price, 0, ',', '.') }}đ
                                    </span>
                                @endif
                            </div>
                        @endforeach

                        <div class="order-status">
                            {{-- <span class="status-label">Giao hàng thành công</span> --}}
                            <span class="status">Trang thái đơn hàng : {{ $order->status }}</span>
                        </div>
                        <div class="order-total">
                            <span>Thành tiền: <b>{{ number_format($order->total_amount, 0, ',', '.') }}đ</b></span>
                        </div>
                        <div class="order-actions">
                            @if ($order->status == 'Hoàn thành')
                                <span>
                                    @if (session('error_' . $order->id))
                                        <p style="color: red">{{ session('error_' . $order->id) }}</p>
                                    @endif
                                </span>

                                <form action="">
                                    <button class="buy-again-btn" type="submit">Mua Lại</button>
                                    <button class="contact-seller-btn" type="submit">Liên Hệ Người Bán</button>
                                </form>
                                <div class="dropdown">
                                    <!-- Nút "Đánh giá Tất Cả" -->
                                    <button class="btn btn-Light dropdown-toggle" type="button" id="dropdownMenuButton"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        bạn có hài lòng với sản phẩm?
                                    </button>
                                    @foreach ($order->orderItems as $item)
                                        <!-- Menu dropdown sẽ hiển thị khi di chuột vào -->
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            @foreach ($order->orderItems as $item)
                                                <li>
                                                    <form
                                                        action="{{ route('comment.form', ['productId' => $item->productVariant->product->id]) }}"
                                                        method="GET">
                                                        <button class="dropdown-item" type="submit">
                                                            {{ $item->productVariant->product->name }}
                                                        </button>
                                                    </form>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endforeach
                                </div>

                            @elseif($order->status == 'Chờ xác nhận')
                                {{-- <form action="{{ route('orders.cancel', $order->id) }}" method="POST">
                                    @csrf
                                    <button class="buy-again-btn" type="submit">Huỷ đơn hàng</button>
                                </form> --}}
                                <form action="{{ route('orders.cancel', $order->id) }}" method="POST">
                                    @csrf
                                    <select name="cancel_reason[{{ $order->id }}]" id="cancel_reason" style="height: 40px">
                                        <option value="">Chọn lí do huỷ đơn</option>
                                        <option value="Thay đổi phương thức thanh toán">Thay đổi phương thức thanh toán</option>
                                        <option value="Thay đổi địa chỉ đặt hàng">Thay đổi địa chỉ đặt hàng</option>
                                        <option value="Chọn nhầm sản phẩm">Chọn nhầm sản phẩm</option>
                                        <option value="Vấn đề thanh toán">Vấn đề thanh toán</option>
                                        <option value="Lý do khác">Lý do khác</option>
                                    </select>
                                    {{-- <input type="text" name="cancel_reason[{{ $order->id }}]" placeholder="Nhập lí do ở đây ..." style="border:none; height:35px" > --}}
                                    <button class="buy-again-btn" type="submit">Huỷ đơn hàng</button>
                                </form>
                                <button class="contact-seller-btn" type="submit">Liên Hệ Người Bán</button><br><br>
                                @error('cancel_reason.' . $order->id)
                                        {{-- <div class="text-danger">{{ $message }}</div> --}}
                                        <script>
                                            alert('{{ $message }}');
                                        </script>
                                @enderror


                            {{-- <button class="contact-seller-btn" type="submit">Liên Hệ Người Bán</button> --}}
                            @elseif($order->status == 'Vận chuyển')
                                <span>
                                    @if (session('error_' . $order->id))
                                        <p style="color: red">{{ session('error_' . $order->id) }}</p>
                                    @endif
                                </span>
                                <button class="contact-seller-btn" type="submit">Liên Hệ Người Bán</button>
                            @elseif($order->status == 'Chờ giao hàng')
                                <span>
                                    @if (session('error_' . $order->id))
                                        <p style="color: red">{{ session('error_' . $order->id) }}</p>
                                    @endif
                                </span>
                                <button class="contact-seller-btn" type="submit">Liên Hệ Người Bán</button>
                            @elseif($order->status == 'Đã huỷ')
                            <span>
                                @if (session('success_' . $order->id))
                                    <p style="color: red">{{ session('success_' . $order->id) }}</p>
                                @endif
                            </span>
                            <form action="{{ route('orders.reorder', $order->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="buy-again-btn">Mua lại</button>
                            </form>
                                <button class="contact-seller-btn" type="submit">Liên Hệ Người Bán</button>
                            @endif
                    </div>
                    </div>
                </div>
            @endforeach


            {{-- dành cho không tìm kiếm --}}
            @else
                    {{-- Hiển thị tất cả đơn hàng --}}
                @if (request('tab') == 'all' || !request('tab'))
                    @foreach ($orders as $order)
                        <div class="order-wrapper" style="margin-top: 20px">
                            <div class="order-card">
                                <div class="shop-info">
                                    <span class="shop-name">Mã đơn hàng : #{{ $order->id }}</span>
                                    <div class="shop-actions">
                                        {{-- <button class="chat-btn">Chat</button>
                                    <button class="view-shop-btn">Xem Shop</button> --}}
                                        <span class="discounted-price">Ngày đặt hàng :
                                            {{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</span>
                                    </div>
                                </div>

                                @foreach ($order->orderItems as $item)
                                    <div class="order-info">
                                        <img src="{{ Storage::url($item->productVariant->image_variant) }}" alt="Bag Image"
                                            class="product-image">
                                        <div class="product-details">
                                            <p class="product-name">{{ $item->productVariant->product->name }}</p>
                                            <p class="product-variant">Phân loại hàng: Màu
                                                {{ $item->productVariant->color->name }} , Kích cỡ
                                                {{ $item->productVariant->size->name }}</p>
                                            <p class="product-quantity">Số lượng : {{ $item->quantity }}x</p>
                                        </div>
                                        @php
                                            // Lấy tất cả các Flash Sale Items của sản phẩm
                                            $flashSaleItems = $item->productVariant->product->flashSaleItems;

                                            // Kiểm tra nếu có Flash Sale và sản phẩm tham gia vào Flash Sale tại thời điểm mua hàng
                                            $flashSaleItem = $flashSaleItems->first(function($flashSale) use ($order) {
                                                return $flashSale->start_time <= $order->order_date && $flashSale->end_time >= $order->order_date;
                                            });

                                            // Lấy giá gốc của sản phẩm
                                            $originalPrice = $item->productVariant->product->price;

                                            // Lấy giá Flash Sale nếu có
                                            $flashSalePrice = $flashSaleItem ? $flashSaleItem->price : null;
                                        @endphp

                                        @if($flashSaleItem)
                                        <div class="product-price">
                                            <span
                                                class="original-price">{{ number_format($flashSalePrice, 0, ',', '.') }}đ</span>
                                            <span
                                                class="discounted-price">{{ number_format($originalPrice, 0, ',', '.') }}đ
                                            </span>
                                        </div>
                                        @else
                                            <span
                                                class="discounted-price">{{ number_format($item->productVariant->product->price, 0, ',', '.') }}đ
                                            </span>
                                        @endif
                                    </div>
                                @endforeach

                                <div class="order-status">
                                    {{-- <span class="status-label">Giao hàng thành công</span> --}}
                                    <span class="status">Trang thái đơn hàng : {{ $order->status }}</span>
                                </div>
                                <div class="order-total">
                                    <span>Thành tiền: <b>{{ number_format($order->total_amount, 0, ',', '.') }}đ</b></span>
                                </div>
                                <div class="order-actions">
                                    @if ($order->status == 'Hoàn thành')
                                        <span>
                                            @if (session('error_' . $order->id))
                                                <p style="color: red">{{ session('error_' . $order->id) }}</p>
                                            @endif
                                        </span>

                                        <form action="">
                                            <button class="buy-again-btn" type="submit">Mua Lại</button>
                                            <button class="contact-seller-btn" type="submit">Liên Hệ Người Bán</button>
                                        </form>
                                        <div class="dropdown">
                                            <!-- Nút "Đánh giá Tất Cả" -->
                                            <button class="btn btn-Light dropdown-toggle" type="button" id="dropdownMenuButton"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                bạn có hài lòng với sản phẩm?
                                            </button>
                                            @foreach ($order->orderItems as $item)
                                                <!-- Menu dropdown sẽ hiển thị khi di chuột vào -->
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    @foreach ($order->orderItems as $item)
                                                        <li>
                                                            <form
                                                                action="{{ route('comment.form', ['productId' => $item->productVariant->product->id]) }}"
                                                                method="GET">
                                                                <button class="dropdown-item" type="submit">
                                                                    {{ $item->productVariant->product->name }}
                                                                </button>
                                                            </form>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endforeach
                                        </div>

                                @elseif($order->status == 'Chờ xác nhận')
                                    {{-- <form action="{{ route('orders.cancel', $order->id) }}" method="POST">
                                        @csrf
                                        <button class="buy-again-btn" type="submit">Huỷ đơn hàng</button>
                                    </form> --}}
                                    <form action="{{ route('orders.cancel', $order->id) }}" method="POST">
                                        @csrf
                                        <select name="cancel_reason[{{ $order->id }}]" id="cancel_reason" style="height: 40px">
                                            <option value="">Chọn lí do huỷ đơn</option>
                                            <option value="Thay đổi phương thức thanh toán">Thay đổi phương thức thanh toán</option>
                                            <option value="Thay đổi địa chỉ đặt hàng">Thay đổi địa chỉ đặt hàng</option>
                                            <option value="Chọn nhầm sản phẩm">Chọn nhầm sản phẩm</option>
                                            <option value="Vấn đề thanh toán">Vấn đề thanh toán</option>
                                            <option value="Lý do khác">Lý do khác</option>
                                        </select>
                                        {{-- <input type="text" name="cancel_reason[{{ $order->id }}]" placeholder="Nhập lí do ở đây ..." style="border:none; height:35px" > --}}
                                        <button class="buy-again-btn" type="submit">Huỷ đơn hàng</button>
                                    </form>
                                    <button class="contact-seller-btn" type="submit">Liên Hệ Người Bán</button><br><br>
                                    @error('cancel_reason.' . $order->id)
                                            {{-- <div class="text-danger">{{ $message }}</div> --}}
                                            <script>
                                                alert('{{ $message }}');
                                            </script>
                                    @enderror


                                    {{-- <button class="contact-seller-btn" type="submit">Liên Hệ Người Bán</button> --}}
                                @elseif($order->status == 'Vận chuyển')
                                    <span>
                                        @if (session('error_' . $order->id))
                                            <p style="color: red">{{ session('error_' . $order->id) }}</p>
                                        @endif
                                    </span>
                                    <button class="contact-seller-btn" type="submit">Liên Hệ Người Bán</button>
                                @elseif($order->status == 'Chờ giao hàng')
                                    <span>
                                        @if (session('error_' . $order->id))
                                            <p style="color: red">{{ session('error_' . $order->id) }}</p>
                                        @endif
                                    </span>
                                    <button class="contact-seller-btn" type="submit">Liên Hệ Người Bán</button>
                                @elseif($order->status == 'Đã huỷ')
                                <span>
                                    @if (session('success_' . $order->id))
                                        <p style="color: red">{{ session('success_' . $order->id) }}</p>
                                    @endif
                                </span>
                                <form action="{{ route('orders.reorder', $order->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="buy-again-btn">Mua lại</button>
                                </form>
                                    <button class="contact-seller-btn" type="submit">Liên Hệ Người Bán</button>
                                @endif
                        </div>
                        </div>
                        </div>
                    @endforeach
                @elseif (request('tab') === 'pending')
                    {{-- Hiển thị đơn hàng đang chờ xác nhận --}}
                    @if ($orders_pending->isEmpty())
                        <p>Hiện tại không có đơn hàng nào đang chờ xác nhận.</p>
                    @else
                        @foreach ($orders_pending as $order)
                            <div class="order-wrapper" style="margin-top: 20px">
                                <div class="order-card">
                                    <div class="shop-info">
                                        <span class="shop-name">Mã đơn hàng :#{{ $order->id }}</span>
                                        {{-- <span class="shop-name">Tên khách hàng : {{ $order->name_order }}</span> --}}
                                        <div class="shop-actions">
                                            {{-- <button class="chat-btn">Chat</button>
                                                <button class="view-shop-btn">Xem Shop</button> --}}
                                            <span class="discounted-price">Ngày đặt hàng :
                                                {{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</span>
                                        </div>
                                    </div>

                                    @foreach ($order->orderItems as $item)
                                        <div class="order-info">
                                            <img src="{{ Storage::url($item->productVariant->image_variant) }}" alt="Bag Image"
                                                class="product-image">
                                            <div class="product-details">
                                                <p class="product-name">{{ $item->productVariant->product->name }}</p>
                                                <p class="product-variant">Phân loại hàng:
                                                    {{ $item->productVariant->color->name }}</p>
                                                <p class="product-quantity">x{{ $item->quantity }}</p>
                                            </div>
                                            <div class="product-price">
                                                <span
                                                    class="original-price">{{ number_format($item->productVariant->product->price, 0, ',', '.') }}đ</span>
                                                <span
                                                    class="discounted-price">{{ number_format($item->productVariant->product->price, 0, ',', '.') }}đ</span>
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="order-status">
                                        {{-- <span class="status-label">Giao hàng thành công</span> --}}
                                        <span class="status">Trạng thái đơn hàng: {{ $order->status }}</span>
                                    </div>
                                    <div class="order-total">
                                        <span>Thành tiền: <b>{{ number_format($order->total_amount, 0, ',', '.') }}đ</b></span>
                                    </div>
                                    <div class="order-actions">
                                        {{-- <form action="{{ route('orders.cancel', $order->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="tab" value="{{ request('tab') }}">
                                            <button class="buy-again-btn" type="submit">Huỷ đơn hàng</button>
                                        </form> --}}
                                        <form action="{{ route('orders.cancel', $order->id) }}" method="POST">
                                            @csrf
                                            <select name="cancel_reason[{{ $order->id }}]" id="cancel_reason" style="height: 40px">
                                                <option value="">Chọn lí do huỷ đơn</option>
                                                <option value="Thay đổi phương thức thanh toán">Thay đổi phương thức thanh toán</option>
                                                <option value="Thay đổi địa chỉ đặt hàng">Thay đổi địa chỉ đặt hàng</option>
                                                <option value="Chọn nhầm sản phẩm">Chọn nhầm sản phẩm</option>
                                                <option value="Vấn đề thanh toán">Vấn đề thanh toán</option>
                                                <option value="Lý do khác">Lý do khác</option>
                                            </select>
                                            <input type="hidden" name="tab" value="{{ request('tab') }}">
                                            {{-- <input type="text" name="cancel_reason[{{ $order->id }}]" placeholder="Nhập lí do ở đây ..." style="border:none; height:35px" > --}}
                                            <button class="buy-again-btn" type="submit">Huỷ đơn hàng</button>
                                        </form>
                                        <button class="contact-seller-btn" type="submit">Liên Hệ Người Bán</button>
                                        @error('cancel_reason.' . $order->id)
                                            {{-- <div class="text-danger">{{ $message }}</div> --}}
                                            <script>
                                                alert('{{ $message }}');
                                            </script>
                                    @enderror
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                @elseif (request('tab') == 'shipping')
                    {{-- Hiển thị đơn hàng đang vận chuyển --}}
                    @if ($orders_vanchuyen->isEmpty())
                        <p>Hiện tại không có đơn hàng nào đang chờ vận chuyển.</p>
                    @else
                        @foreach ($orders_vanchuyen as $order)
                            <div class="order-wrapper" style="margin-top: 20px">
                                <div class="order-card">
                                    <div class="shop-info">
                                        <span class="shop-name">Mã đơn hàng :#{{ $order->id }}</span>
                                        <div class="shop-actions">
                                            {{-- <button class="chat-btn">Chat</button>
                                                <button class="view-shop-btn">Xem Shop</button> --}}
                                            <span class="discounted-price">Ngày đặt hàng :
                                                {{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</span>
                                        </div>
                                    </div>

                                    @foreach ($order->orderItems as $item)
                                        <div class="order-info">
                                            <img src="{{ Storage::url($item->productVariant->image_variant) }}" alt="Bag Image"
                                                class="product-image">
                                            <div class="product-details">
                                                <p class="product-name">{{ $item->productVariant->product->name }}</p>
                                                <p class="product-variant">Phân loại hàng:
                                                    {{ $item->productVariant->color->name }}</p>
                                                <p class="product-quantity">x{{ $item->quantity }}</p>
                                            </div>
                                            <div class="product-price">
                                                <span
                                                    class="original-price">{{ number_format($item->productVariant->product->price, 0, ',', '.') }}đ</span>
                                                <span
                                                    class="discounted-price">{{ number_format($item->productVariant->product->price, 0, ',', '.') }}đ</span>
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="order-status">
                                        {{-- <span class="status-label">Giao hàng thành công</span> --}}
                                        <span class="status">Đơn hàng đã được xác nhận và đang trong quá trình vận
                                            chuyển</span>
                                    </div>
                                    <div class="order-total">
                                        <span>Thành tiền: <b>{{ number_format($order->total_amount, 0, ',', '.') }}đ</b></span>
                                    </div>
                                    <div class="order-actions">
                                        <form action="">
                                            {{-- <button class="buy-again-btn" type="submit">Mua Lại</button> --}}
                                            <button class="contact-seller-btn" type="submit">Liên Hệ Người Bán</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                @elseif (request('tab') == 'delivery')
                    {{-- Hiển thị đơn hàng đang chờ giao --}}
                    @if ($orders_chogiaohang->isEmpty())
                        <p>Hiện tại không có đơn hàng nào đang chờ giao.</p>
                    @else
                        @foreach ($orders_chogiaohang as $order)
                            <div class="order-wrapper" style="margin-top: 20px">
                                <div class="order-card">
                                    <div class="shop-info">
                                        <span class="shop-name">Mã đơn hàng :#{{ $order->id }}</span>
                                        <div class="shop-actions">
                                            {{-- <button class="chat-btn">Chat</button>
                                                <button class="view-shop-btn">Xem Shop</button> --}}
                                            <span class="discounted-price">Ngày đặt hàng :
                                                {{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</span>
                                        </div>
                                    </div>

                                    @foreach ($order->orderItems as $item)
                                        <div class="order-info">
                                            <img src="{{ Storage::url($item->productVariant->image_variant) }}" alt="Bag Image"
                                                class="product-image">
                                            <div class="product-details">
                                                <p class="product-name">{{ $item->productVariant->product->name }}</p>
                                                <p class="product-variant">Phân loại hàng:
                                                    {{ $item->productVariant->color->name }}</p>
                                                <p class="product-quantity">x{{ $item->quantity }}</p>
                                            </div>
                                            <div class="product-price">
                                                <span
                                                    class="original-price">{{ number_format($item->productVariant->product->price, 0, ',', '.') }}đ</span>
                                                <span
                                                    class="discounted-price">{{ number_format($item->productVariant->product->price, 0, ',', '.') }}đ</span>
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="order-status">
                                        {{-- <span class="status-label">Giao hàng thành công</span> --}}
                                        <span class="status">Đơn hàng đang trên đường và chờ giao tới bạn</span>
                                    </div>
                                    <div class="order-total">
                                        <span>Thành tiền: <b>{{ number_format($order->total_amount, 0, ',', '.') }}đ</b></span>
                                    </div>
                                    <div class="order-actions">
                                        <form action="">
                                            {{-- <button class="buy-again-btn" type="submit">Mua Lại</button> --}}
                                            <button class="contact-seller-btn" type="submit">Đã nhận được hàng</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                @elseif (request('tab') == 'completed')
                    {{-- Hiển thị đơn hàng hoàn thành --}}
                    @if ($orders_hoanthanh->isEmpty())
                        <p>Hiện tại không có đơn hàng nào đã hoàn thành.</p>
                    @else
                        @foreach ($orders_hoanthanh as $order)
                            <div class="order-wrapper" style="margin-top: 20px">
                                <div class="order-card">
                                    <div class="shop-info">
                                        <span class="shop-name">Mã đơn hàng :#{{ $order->id }}</span>
                                        <div class="shop-actions">
                                            {{-- <button class="chat-btn">Chat</button>
                                                <button class="view-shop-btn">Xem Shop</button> --}}
                                            <span class="discounted-price">Ngày đặt hàng :
                                                {{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</span>
                                        </div>
                                    </div>

                                    @foreach ($order->orderItems as $item)
                                        <div class="order-info">
                                            <img src="{{ Storage::url($item->productVariant->image_variant) }}" alt="Bag Image"
                                                class="product-image">
                                            <div class="product-details">
                                                <p class="product-name">{{ $item->productVariant->product->name }}</p>
                                                <p class="product-variant">Phân loại hàng:
                                                    {{ $item->productVariant->color->name }}</p>
                                                <p class="product-quantity">x{{ $item->quantity }}</p>
                                            </div>
                                            <div class="product-price">
                                                <span
                                                    class="original-price">{{ number_format($item->productVariant->product->price, 0, ',', '.') }}đ</span>
                                                <span
                                                    class="discounted-price">{{ number_format($item->productVariant->product->price, 0, ',', '.') }}đ</span>
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="order-status">
                                        {{-- <span class="status-label">Giao hàng thành công</span> --}}
                                        <span class="status">Đơn hàng đã được hoàn thành và giao thành công </span>
                                    </div>
                                    <div class="order-total">
                                        <span>Thành tiền: <b>{{ number_format($order->total_amount, 0, ',', '.') }}đ</b></span>
                                    </div>



                                    <div class="order-actions">
                                        <form action="{{ route('orders.reorder', $order->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="buy-again-btn">Mua lại</button>
                                        </form>
                                        <button class="contact-seller-btn" type="submit">Liên Hệ Người Bán</button>
                                        <div class="dropdown">
                                            <!-- Nút "Đánh giá Tất Cả" -->
                                            <button class="btn btn-Light dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                bạn có hài lòng với sản phẩm?
                                            </button>
                                            @foreach ($order->orderItems as $item)
                                                    <!-- Menu dropdown sẽ hiển thị khi di chuột vào -->
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        @foreach ($order->orderItems as $item)
                                                            <li>
                                                                <form
                                                                    action="{{ route('comment.form', ['productId' => $item->productVariant->product->id]) }}"
                                                                    method="GET">
                                                                    <button class="dropdown-item" type="submit">
                                                                        {{ $item->productVariant->product->name }}
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        @endforeach
                                                    </ul>

                                            @endforeach
                                        </div>
                                    </div>


                                </div>
                            </div>
                        @endforeach
                    @endif
                @elseif (request('tab') == 'cancelled')
                    {{-- Hiển thị đơn hàng đã bị hủy --}}
                    @if ($orders_dahuy->isEmpty())
                        <p>Hiện tại không có đơn hàng nào đã huỷ</p>
                    @else
                        @foreach ($orders_dahuy as $order)
                            <div class="order-wrapper" style="margin-top: 20px">
                                <div class="order-card">
                                    <div class="shop-info">
                                        <span class="shop-name">Mã đơn hàng :#{{ $order->id }}</span>
                                        <div class="shop-actions">
                                            {{-- <button class="chat-btn">Chat</button>
                                                <button class="view-shop-btn">Xem Shop</button> --}}
                                            <span class="discounted-price">Ngày đặt hàng :
                                                {{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</span>
                                        </div>
                                    </div>

                                    @foreach ($order->orderItems as $item)
                                        <div class="order-info">
                                            <img src="{{ Storage::url($item->productVariant->image_variant) }}" alt="Bag Image"
                                                class="product-image">
                                            <div class="product-details">
                                                <p class="product-name">{{ $item->productVariant->product->name }}</p>
                                                <p class="product-variant">Phân loại hàng:
                                                    {{ $item->productVariant->color->name }}</p>
                                                <p class="product-quantity">x{{ $item->quantity }}</p>
                                            </div>
                                            <div class="product-price">
                                                <span
                                                    class="original-price">{{ number_format($item->productVariant->product->price, 0, ',', '.') }}đ</span>
                                                <span
                                                    class="discounted-price">{{ number_format($item->productVariant->product->price, 0, ',', '.') }}đ</span>
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="order-status">
                                        {{-- <span class="status-label">Đơn hàng đã bị huỷ</span> --}}
                                        <span class="status">Lí do huỷ đơn : {{$order->cancel_reason}}</span>
                                    </div>
                                    <div class="order-total">
                                        <span>Thành tiền: <b>{{ number_format($order->total_amount, 0, ',', '.') }}đ</b></span>
                                    </div>
                                    <div class="order-actions">
                                        <form action="{{ route('orders.reorder', $order->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="buy-again-btn">Mua lại</button>
                                        </form>
                                        {{-- <form action="">
                                            <button class="buy-again-btn" type="submit">Mua Lại</button> --}}
                                            <button class="contact-seller-btn" type="submit">Liên Hệ Người Bán</button>
                                        {{-- </form> --}}

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                @elseif (request('tab') == 'return')
                    {{-- Hiển thị đơn hàng trả lại hoặc hoàn tiền --}}
                    <div class="tab-content">
                        <p>Nội dung cho "Trả hàng/Hoàn tiền".</p>
                    </div>
                @endif
            @endif
        </div>
    </div>



    <style>
        .tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            border-bottom: 2px solid #eee;
        }

        .tabs a {
            text-decoration: none;
            padding: 10px 15px;
            font-size: 14px;
            color: #555;
            border-bottom: 2px solid transparent;
        }

        .tabs a.active {
            color: #ff5722;
            border-bottom: 2px solid #ff5722;
        }

        .tab-content {
            display: none;
            padding: 20px;
            border: 1px solid #000000;
            border-radius: 5px;
            background-color: #fff;
        }

        .tab-content.active {
            display: block;
        }

        .tabs {
            background: #eeeaea;
            /* text-align: center; */
        }

        .tabs a {
            text-align: center;
            margin-left: 4%
        }

        /* Hiển thị dropdown khi di chuột vào */
        .dropdown:hover .dropdown-menu {
            display: block;
        }

        /* Tạo hiệu ứng khi di chuột vào các item trong menu */
        .dropdown-item:hover {
            background-color: #f1f1f1;
            outline: none; /* Loại bỏ viền */
        }
    </style>
    </section>
@endsection
