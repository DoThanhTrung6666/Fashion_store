<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PaymentController;
use App\Models\Cart;
use App\Models\FlashSaleItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // voucher
    public function applyVoucher(Request $request)
    {
        $user = Auth::user();
        $cart = Cart::with('cartItems.productVariant')->where('user_id', $user->id)->first();

        // Đặt giá trị voucher_discount về 0 trước khi tính toán


        // Lấy mã voucher từ input
        $voucherCode = $request->input('voucher');

        // Kiểm tra mã voucher có hợp lệ không
        $voucher = Voucher::where('name', $voucherCode)
            ->where('status', 2) // Chỉ lấy voucher đang hoạt động
            ->first();

        if (!$voucher) {
            return redirect()->back()->with('error', 'Mã giảm giá không hợp lệ.');
        }

        // Tính tổng giá trị đơn hàng
        $totalPrice = $cart->cartItems->sum(function ($cartItem) {
            $flashSaleItem = FlashSaleItem::where('product_id', $cartItem->productVariant->product->id)
                ->whereHas('flashSale', function ($query) {
                    $query->where('status', 2);
                })
                ->first();

            $finalPrice = $flashSaleItem ? $flashSaleItem->price : $cartItem->productVariant->product->price;
            return $finalPrice * $cartItem->quantity;
        });

        // Tính toán giá trị giảm giá
        $discountAmount = ($totalPrice * $voucher->discount_percentage) / 100;

        // Nếu giá trị giảm lớn hơn giá trị tối đa của voucher, áp dụng max_discount
        if ($discountAmount > $voucher->max_discount) {
            $discountAmount = $voucher->max_discount;
        }

        // Nếu tổng giá trị đơn hàng lớn hơn hoặc bằng min_order_value, áp dụng giảm theo min_order_value
        if ($totalPrice >= $voucher->min_order_value) {
            $discountAmount = min($voucher->min_order_value, $discountAmount);
        }

        // Lưu voucher vào session với giá trị giảm
        session()->put('voucher_discount', [
            'voucher_code' => $voucher->name,
            'discount_percentage' => $voucher->discount_percentage,
            'min_order_value' => $voucher->min_order_value,
            'max_discount' => $voucher->max_discount,
            'status' => $voucher->status,
            'discount_amount' => $discountAmount // Lưu giá trị giảm
        ]);

        // Redirect lại trang giỏ hàng với thông báo và cập nhật session
        return back()->with('success', 'Mã giảm giá đã được áp dụng. Giảm giá: ' . number_format($discountAmount) . ' VNĐ');
    }

    //thanh toán online
    public function createOrder(Request $request)
    {
        $user = Auth::user();
        $cart = Cart::with('cartItems.productVariant')->where('user_id', $user->id)->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        // Xác thực dữ liệu đầu vào
        $validate = $request->validate([
            'name_order' => 'required|string|max:255',
            'phone_order' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|max:15',
            'address_order' => 'required|string|min:10|max:500',
        ], [
            'name_order.required' => 'Vui lòng nhập tên người đặt hàng.',
            'name_order.string' => 'Tên phải là chuỗi ký tự.',
            'name_order.max' => 'Tên không được dài hơn 255 ký tự.',

            'phone_order.required' => 'Vui lòng nhập số điện thoại.',
            'phone_order.regex' => 'Số điện thoại không đúng định dạng.',

            'address_order.required' => 'Vui lòng nhập địa chỉ.',
            'address_order.string' => 'Địa chỉ phải là chuỗi ký tự.',
            'address_order.min' => 'Địa chỉ phải có ít nhất 10 ký tự.',
            'address_order.max' => 'Địa chỉ không được dài hơn 500 ký tự.',
        ]);

        // Tính tổng tiền giỏ hàng
        $totalPrice = $cart->cartItems->sum(function ($cartItem) {
            return $cartItem->quantity * $cartItem->productVariant->product->price;
        });

        // Lấy discountAmount từ session
        $discountAmount = session()->has('voucher_discount') ? session()->get('voucher_discount')['discount_amount'] : 0;

        // Tính toán số tiền cần thanh toán (bao gồm phí giao hàng)
        $vnp_Amount = ($totalPrice - $discountAmount + 30000) * 100;

        // Chuyển hướng sang VnPay (cần truyền thêm `vnp_Amount` qua request)
        $request->merge(['vnp_Amount' => $vnp_Amount]);
        return app(PaymentController::class)->vnpay_payment($request);
    }

    public function createOrderAfterPayment($cartId, $orderData)
    {
        $cart = Cart::with('cartItems.productVariant')->find($cartId);
        if (!$cart) {
            return redirect()->route('checkout')->with('error', 'Giỏ hàng không tồn tại.');
        }

        // Gọi hàm để tạo đơn hàng sau khi thanh toán thành công
        return $this->createOrderOnline($cart, $orderData);
    }

    public function createOrderOnline($cart, $orderData)
    {
        $user = Auth::user();

        $totalPrice = $cart->cartItems->sum(function ($item) {
            return $item->quantity * $item->productVariant->product->price;
        });

        // Tạo đơn hàng
        $order = Order::create([
            'user_id' => $user->id,
            'payment' => 2,
            'order_date' => now(),
            'status' => 'Chờ xác nhận',
            'total_amount' => $totalPrice + 30000, // Tính phí giao hàng
            'name_order' => $orderData['name_order'],
            'phone_order' => $orderData['phone_order'],
            'address_order' => $orderData['address_order'],
            'content_order' => $orderData['content_order'], // Mặc định rỗng nếu không có giá trị
        ]);

        foreach ($cart->cartItems as $item) {
            $productVariant = $item->productVariant;

            // Kiểm tra số lượng tồn kho
            if ($productVariant->stock_quantity < $item->quantity) {
                return redirect()->back()->with('error', 'Sản phẩm ' . $productVariant->product->name . ' không đủ số lượng trong kho.');
            }

            // Cập nhật tồn kho
            $productVariant->stock_quantity -= $item->quantity;
            $productVariant->save();

            // Tạo sản phẩm trong đơn hàng
            OrderItem::create([
                'order_id' => $order->id,
                'product_variant_id' => $item->productVariant->id,
                'quantity' => $item->quantity,
                'price' => $item->productVariant->product->price
            ]);
        }

        // Xóa giỏ hàng sau khi đặt hàng thành công
        $cart->cartItems()->delete();
        $cart->delete();

        return redirect()->route('thankyou')->with('success', 'Đặt hàng thành công.');
    }
    //thanh toán khi nhận hàng
    public function Order(Request $request)
    {
        $user = Auth::user();
        $cart = Cart::with('cartItems.productVariant')->where('user_id', $user->id)->first();

        // kiểm tra xem giỏ hàng có rỗng không
        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        // Lọc các sản phẩm ngừng kinh doanh
        $inactiveItems = $cart->cartItems->filter(function ($cartItem) {
            return $cartItem->productVariant->product->status == 2;
        });

        // Nếu có sản phẩm ngừng kinh doanh, hiển thị thông báo và quay lại giỏ hàng
        if ($inactiveItems->count() > 0) {
            $inactiveProductNames = $inactiveItems->pluck('productVariant.product.name')->join(', ');
            return redirect()->route('cart.load')->with('error', 'Các sản phẩm sau đã ngừng kinh doanh: ' . $inactiveProductNames . '. Vui lòng xoá chúng khỏi giỏ hàng.');
        }
        if ($cart) {
            // tính tổng tiền
            $totalPrice = $cart->cartItems->sum(function ($cartItem) {
                // Lấy thông tin Flash Sale nếu có
                $flashSaleItem = FlashSaleItem::where('product_id', $cartItem->productVariant->product->id)
                    ->whereHas('flashSale', function ($query) {
                        $query->where('start_time', '<=', now())
                            ->where('end_time', '>=', now())
                            ->where('status', 'active');
                    })
                    ->first();

                // Sử dụng giá giảm nếu có Flash Sale, nếu không dùng giá gốc
                $finalPrice = $flashSaleItem ? $flashSaleItem->price : $cartItem->productVariant->product->price;

                // Tính giá theo số lượng sản phẩm
                return $finalPrice * $cartItem->quantity;
            });
        }
        $discountAmount = session()->has('voucher_discount') ? session()->get('voucher_discount')['discount_amount'] : 0;
        $validate = $request->validate([
            'name_order' => 'required|string|max:255',
            'phone_order' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|max:15',
            'address_order' => 'required|string|min:10|max:500',
        ], [
            'name_order.required' => 'Vui lòng nhập tên người đặt hàng.',
            'name_order.string' => 'Tên phải là chuỗi ký tự.',
            'name_order.max' => 'Tên không được dài hơn 255 ký tự.',

            'phone_order.required' => 'Vui lòng nhập số điện thoại.',
            'phone_order.regex' => 'Số điện thoại không đúng định dạng.',

            'address_order.required' => 'Vui lòng nhập địa chỉ.',
            'address_order.string' => 'Địa chỉ phải là chuỗi ký tự.',
            'address_order.min' => 'Địa chỉ phải có ít nhất 10 ký tự.',
            'address_order.max' => 'Địa chỉ không được dài hơn 500 ký tự.',
        ]);
        // tạo đơn hàng mới
        $order = Order::create([
            'user_id' => $user->id,
            'payment' => 1,
            'order_date' => now(),
            'status' => 'Chờ xác nhận',
            // 'total_amount' => $totalPrice + 30000,
            'total_amount' => $totalPrice - $discountAmount + 30000,
            'name_order' => $request->name_order,
            'phone_order' => $request->phone_order,
            'address_order' => $request->address_order,
            'content_order' => $request->content_order
        ]);
        // tạo các mục đơn hàng từ giỏ hàng
        foreach ($cart->cartItems as $item) {
            if (!$item->productVariant) {
                return redirect()->back()->with('error', 'Sản phẩm không tồn tại hoặc không có sẵn.');
            }
            // Cập nhật số lượng tồn kho của biến thể sản phẩm
            $productVariant = $item->productVariant;

            // Kiểm tra xem số lượng tồn kho có đủ không
            if ($productVariant->stock_quantity < $item->quantity) {
                return redirect()->back()->with('error', 'Sản phẩm ' . $productVariant->product->name . ' không đủ số lượng trong kho.');
            }

            // Trừ số lượng của biến thể sản phẩm
            $productVariant->stock_quantity -= $item->quantity;
            $productVariant->save();
            $flashSaleItem = FlashSaleItem::where('product_id', $productVariant->product->id)
                ->whereHas('flashSale', function ($query) {
                    $query->where('start_time', '<=', now())
                        ->where('end_time', '>=', now())
                        ->where('status', 'active');
                })
                ->first();

            $finalPrice = $flashSaleItem ? $flashSaleItem->price : $productVariant->product->price;

            // Tạo mục đơn hàng
            OrderItem::create([
                'order_id' => $order->id,
                // dd($item->product_variant_id),
                'product_variant_id' => $item->productVariant->id,
                'quantity' => $item->quantity,
                'price' => $finalPrice
            ]);
        }
        // xoá giỏ hàng khi mua thành công
        $cart->cartItems()->delete();
        $cart->delete();

        return redirect()->route('thankyou');
    }
    public function loadOrderUser()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->with('orderItems')->get();
        return view('client.order', compact('orders'));
    }
    // OrderController.php
    public function show($orderId)
    {
        $order = Order::with(['orderItems.productVariant.size', 'orderItems.productVariant.color'])
            ->where('user_id', auth()->id())
            ->where('id', $orderId)
            ->first();

        return view('client.orderdetail', compact('order'));
    }

    public function cancelOrder($orderId)
    {
        $order = Order::where('user_id', auth()->id())
            ->where('id', $orderId)
            ->first();

        if ($order) {
            $order->status = 'Hủy đơn hàng';
            $order->save();

            return redirect()->route('orders.loadUser')->with('success', 'Đơn hàng đã được hủy.');
        }

        return redirect()->route('orders.loadUser')->with('error', 'Không thể hủy đơn hàng này.');
    }


    // xử lí mua lại
    public function repurchase($orderId)
    {
        $user = Auth::user(); // Lấy thông tin người dùng đang đăng nhập

        // Lấy đơn hàng đã huỷ mà người dùng muốn mua lại
        $oldOrder = Order::with('orderItems.productVariant')->where('id', $orderId)->where('user_id', $user->id)->first();

        // Nếu không tìm thấy đơn hàng
        if (!$oldOrder) {
            return redirect()->back()->with('error', 'Đơn hàng không tìm thấy.');
        }

        // Kiểm tra nếu đơn hàng cũ không phải là "Đã huỷ"
        if ($oldOrder->status !== 'Hủy đơn hàng') {
            return redirect()->back()->with('error', 'Đơn hàng này không thể mua lại vì trạng thái không phải là "Đã huỷ".');
        }

        // Kiểm tra số lượng tồn kho của sản phẩm trong đơn hàng cũ
        foreach ($oldOrder->orderItems as $item) {
            $productVariant = $item->productVariant;

            // Kiểm tra số lượng tồn kho của sản phẩm
            if ($productVariant->stock_quantity < $item->quantity) {
                return redirect()->back()->with('error', 'Sản phẩm ' . $productVariant->product->name . ' không đủ số lượng trong kho.');
            }
        }

        // Cập nhật trạng thái đơn hàng từ "Đã huỷ" thành "Chờ xác nhận"
        $oldOrder->status = 'Chờ xác nhận';
        $oldOrder->save();

        // Thông báo thành công và chuyển đến trang cảm ơn hoặc trang chi tiết đơn hàng
        return redirect()->back()->with('success', 'Đơn hàng của bạn đã được khôi phục và đang chờ xác nhận.');
    }
}
