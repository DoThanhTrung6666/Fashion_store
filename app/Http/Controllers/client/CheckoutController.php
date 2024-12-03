<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PaymentController;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
// use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    //
    public function viewCheckout()
    {

        $user = Auth::user();
        if ($user !== null) {
            $cart = Cart::with('cartItems.productVariant')->where('user_id', $user->id)->first();
            if ($cart) {
                $totalPrice = $cart->cartItems->sum(function ($item) {
                    return $item->quantity * $item->productVariant->product->price;
                });
                return view('client.checkout', compact('user', 'cart', 'totalPrice'));
            } else {
                return view('client.checkout', compact('user', 'cart'));
            }
        } else {
            return view('client.checkout', compact('user'));
        }
    }
    public function thankyou()
    {
        return view('client.thankyou');
    }

    // public function handleCheckout(Request $request)
    // {

    //     // Lấy thông tin từ request
    //     $productId = $request->input('product_id');
    //     $colorId = $request->input('color_id');
    //     $sizeId = $request->input('size_id');
    //     $quantity = $request->input('quantity');
    //     $paymentMethod = $request->input('payment_method'); // Lấy phương thức thanh toán
    //     dd($request->getContent());



    //     // Lấy thông tin sản phẩm
    //     $product = Product::findOrFail($productId);

    //     // Lấy variant của sản phẩm theo color_id và size_id
    //     $selectedVariant = $product->variants()
    //         ->where('color_id', $colorId)
    //         ->where('size_id', $sizeId)
    //         ->first();

    //     // Nếu không tìm thấy variant phù hợp
    //     if (!$selectedVariant) {
    //         return redirect()->route('product.detail', ['id' => $productId])->with('error', 'Sản phẩm không hợp lệ.');
    //     }

    //     // Tính toán tổng tiền
    //     $totalAmount = $selectedVariant->price * $quantity;

    //     // Kiểm tra tính hợp lệ của phương thức thanh toán
    //     if (!in_array($paymentMethod, ['cod', 'vnpay'])) {
    //         return back()->withErrors(['error' => 'Phương thức thanh toán không hợp lệ.']);
    //     }

    //     // Tạo đơn hàng
    //     $order = new Order();
    //     $order->user_id = Auth::id(); // Lấy ID người dùng đang đăng nhập
    //     $order->product_id = $productId;
    //     $order->variant_id = $selectedVariant->id;
    //     $order->quantity = $quantity;
    //     $order->total_amount = $totalAmount;
    //     $order->payment = $paymentMethod;
    //     $order->status = $paymentMethod === 'cod' ? 'Pending' : 'Processing'; // Trạng thái đơn hàng
    //     $order->order_date = now();
    //     $order->save();

    //     // Xử lý theo phương thức thanh toán
    //     if ($paymentMethod === 'cod') {
    //         // Nếu là thanh toán khi nhận hàng, hiển thị trang thankyou
    //         return redirect()->route('thankyou');
    //     } elseif ($paymentMethod === 'vnpay') {
    //         // Nếu là thanh toán qua VNPay, chuyển hướng sang PaymentController để xử lý
    //         $paymentController = app(PaymentController::class);
    //         $request->merge(['total' => $totalAmount]); // Thêm giá trị total vào request
    //         $vnpayUrl = $paymentController->vnpay_payment($request);

    //         return redirect($vnpayUrl);
    //     }
    // }
}
