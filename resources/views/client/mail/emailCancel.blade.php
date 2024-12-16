<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
        }

        .header {
            background: rgb(173, 78, 78);
            padding: 10px;
            text-align: center;
            color: white;
        }

        .order-details {
            margin-top: 20px;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Cảm ơn bạn đã đặt hàng tại Fashion Store!</h2>
        </div>
        <p>Xin chào {{ $order->name_order}},</p>
        <p>Chúng tôi đã huỷ đơn hàng của bạn. Dưới đây là thông tin chi tiết:</p>
        <div class="order-details">
            <p><strong>Mã đơn hàng:</strong> {{ $order->id }}</p>
            <p><strong>Sản phẩm:</strong></p>
            <ul>
                {{-- @foreach($order->orderItems as $item)
                    <li>
                        {{ $item['orderItems']->productVariant->product->name }} (x{{ $item['orderItems']->quantity }}) - {{ number_format($item['orderItems']->price, 0) }} VND
                    </li>
                @endforeach --}}
            </ul>
            <p><strong>Tổng tiền:</strong> {{$order->total_amount }} VND</p>
            <p><strong>Địa chỉ giao hàng:</strong> {{$order->address_order }}</p>
        </div>
        <p>Chúng tôi xin lỗi vì sự cố ngoài ý muốn , Hãy quay lại sau nhé ❤!</p>
        <div class="footer">
            <p>Fashion Store - Mong bạn thông cảm nhé 💖!</p>
        </div>
    </div>
    <footer style="margin-top: 1.5rem; width: 100%; text-align: center; color: #718096;">© 2024 Fashion_store. All rights
        reserved.</footer>
</body>

</html>
