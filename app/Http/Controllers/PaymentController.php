<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Client\OrderController;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function vnpay_payment(Request $request)
    {
        $user = Auth::user();
        $cart = Cart::with('cartItems.productVariant')->where('user_id', $user->id)->first();

        $selectedCartItemIds = $request->input('selectedCartItemIds', []); // Lấy danh sách các sản phẩm đã chọn
        $selectedCartItems = $cart->cartItems->whereIn('id', $selectedCartItemIds);

        // Tính tổng tiền giỏ hàng cho các sản phẩm đã chọn
        $totalPrice = $selectedCartItems->sum(function ($cartItem) {
            $flashSaleItem = \App\Models\FlashSaleItem::where('product_id', $cartItem->productVariant->product->id)
                ->whereHas('flashSale', function ($query) {
                    $query->where('start_time', '<=', now())
                        ->where('end_time', '>=', now())
                        ->where('status', 'active');
                })
                ->first();

            $finalPrice = $flashSaleItem ? $flashSaleItem->price : $cartItem->productVariant->product->price;
            return $finalPrice * $cartItem->quantity;
        });

        $discountAmount = session()->has('voucher_discount') ? session()->get('voucher_discount')['discount_amount'] : 0;

        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('vnpay.callback');
        $vnp_TmnCode = "36NWPRAB"; // Mã website tại VNPAY
        $vnp_HashSecret = "KSA6N5HG030067AN7MJK54AA8U5JFH57"; // Chuỗi bí mật

        // Mã đơn hàng
        $vnp_TxnRef = $cart->id;
        $vnp_OrderInfo = "Thanh toán hóa đơn";
        $vnp_OrderType = "billpayment";
        $vnp_Amount = ($totalPrice - $discountAmount + 30000) * 100; // Tổng tiền (tính bằng đồng)
        $vnp_Locale = "vn";
        $vnp_BankCode = "NCB"; // Giả lập, thực tế người dùng chọn ngân hàng
        $vnp_IpAddr = $request->ip();

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => now()->format('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        ];

        ksort($inputData);
        $query = http_build_query($inputData);
        $vnpSecureHash = hash_hmac('sha512', $query, $vnp_HashSecret);

        $vnp_Url .= "?" . $query . "&vnp_SecureHash=" . $vnpSecureHash;

        // Lưu thông tin tạm thời vào session
        session([
            'vnp_TxnRef' => $vnp_TxnRef,
            'cart_id' => $cart->id,
            'name_order' => $request->input('name_order'),
            'phone_order' => $request->input('phone_order'),
            'address_order' => $request->input('address_order'),
            'content_order' => $request->input('content_order', ''),
            'selectedCartItemIds' => $selectedCartItemIds, // Lưu selectedCartItemIds vào session
        ]);

        return redirect($vnp_Url);
    }


    public function vnpay_callback(Request $request)
    {
        $vnp_HashSecret = "KSA6N5HG030067AN7MJK54AA8U5JFH57"; // Chuỗi bí mật
        $inputData = $request->all();
        $vnp_SecureHash = $inputData['vnp_SecureHash'];

        unset($inputData['vnp_SecureHash']);
        unset($inputData['vnp_SecureHashType']);
        ksort($inputData);
        $query = http_build_query($inputData);
        $secureHash = hash_hmac('sha512', $query, $vnp_HashSecret);

        if ($secureHash !== $vnp_SecureHash) {
            return redirect()->route('checkout')->with('error', 'Thanh toán không hợp lệ.');
        }

        if ($inputData['vnp_ResponseCode'] == '00') {
            $cartId = session('cart_id');

            // Lấy thông tin từ session
            $orderData = [
                'name_order' => session('name_order'),
                'phone_order' => session('phone_order'),
                'address_order' => session('address_order'),
                'content_order' => session('content_order'),
                'selectedCartItemIds' => session('selectedCartItemIds'), // Lấy selectedCartItemIds từ session
            ];

            session()->forget(['vnp_TxnRef', 'cart_id', 'name_order', 'phone_order', 'address_order', 'content_order', 'selectedCartItemIds']); // Xóa session sau khi xử lý

            return app(OrderController::class)->createOrderAfterPayment($cartId, $orderData);
        }

        return redirect()->route('checkout')->with('error', 'Thanh toán không thành công.');
    }
}
