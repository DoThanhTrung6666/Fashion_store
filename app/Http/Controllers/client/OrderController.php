<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PaymentController;
use App\Mail\mailOrder;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\FlashSaleItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Voucher;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    // public function applyVoucher(Request $request)
    // {
    //     $user = Auth::user();
    //     $cart = Cart::with('cartItems.productVariant')->where('user_id', $user->id)->first();
    //     $voucherCode = $request->input('voucher');
    //     $selectedCartItemIds = $request->input('selectedCartItemIds', []);
    //     $selectedCartItems = $cart->cartItems->whereIn('id', $selectedCartItemIds);

    //     $voucher = Voucher::where('name', $voucherCode)
    //         ->where('status', 2) // Voucher đang hoạt động
    //         ->first();

    //     // if (!$voucher) {
    //     //     return redirect()->back()->with(
    //     //         'error',
    //     //         'Mã giảm giá không hợp lệ.'
    //     //     );
    //     // }

    //     // Kiểm tra xem người dùng đã sử dụng voucher này chưa
    //     $isVoucherUsed = DB::table('voucher_uses')
    //         ->where('user_id', $user->id)
    //         ->where('voucher_id', $voucher->id)
    //         ->exists();

    //     if ($isVoucherUsed) {
    //         return redirect()->back()->with('error', 'Bạn đã sử dụng mã giảm giá này.');
    //     }

    //     // Tính tổng giá trị của các sản phẩm đã chọn
    //     $totalPrice = $selectedCartItems->sum(function ($cartItem) {
    //         $flashSaleItem = FlashSaleItem::where('product_id', $cartItem->productVariant->product->id)
    //             ->whereHas('flashSale', function ($query) {
    //                 $query->where('start_time', '<=', now())
    //                     ->where('end_time', '>=', now())
    //                     ->where('status', 'active');
    //             })
    //             ->first();

    //         $finalPrice = $flashSaleItem ? $flashSaleItem->price : $cartItem->productVariant->product->price;
    //         return $finalPrice * $cartItem->quantity;
    //     });

    //     $discountAmount = ($totalPrice * $voucher->discount_percentage) / 100;

    //     if ($discountAmount > $voucher->max_discount) {
    //         $discountAmount = $voucher->max_discount;
    //     }

    //     if ($totalPrice >= $voucher->min_order_value) {
    //         $discountAmount = min($totalPrice, $discountAmount);
    //     }

    //     // Lưu thông tin voucher đã sử dụng vào cơ sở dữ liệu
    //     DB::table('voucher_uses')->insert([
    //         'user_id' => $user->id,
    //         'voucher_id' => $voucher->id,
    //         'created_at' => now(),
    //         'updated_at' => now(),
    //     ]);

    //     session()->put('voucher_discount', [
    //         'voucher_code' => $voucher->name,
    //         'discount_percentage' => $voucher->discount_percentage,
    //         'min_order_value' => $voucher->min_order_value,
    //         'max_discount' => $voucher->max_discount,
    //         'status' => $voucher->status,
    //         'discount_amount' => $discountAmount
    //     ]);

    //     // Trong controller sau khi xử lý voucher
    //     if ($voucher) {
    //         // Thông báo thành công
    //         return back()->with('success', 'Mã giảm giá đã được áp dụng. Giảm giá: ' . number_format($discountAmount) . ' VNĐ');
    //     } else {
    //         // Thông báo lỗi
    //         return redirect()->back()->with('error', 'Mã giảm giá không hợp lệ.');
    //     }
    // }
    public function applyVoucher(Request $request)
    {
        $user = Auth::user();
        $cart = Cart::with('cartItems.productVariant')->where('user_id', $user->id)->first();
        $voucherCode = $request->input('voucher');
        $selectedCartItemIds = $request->input('selectedCartItemIds', []);
        $selectedCartItems = $cart->cartItems->whereIn('id', $selectedCartItemIds);

        $voucher = Voucher::where('name', $voucherCode)
            ->where('status', 2) // Voucher đang hoạt động
            ->first();

        // if (!$voucher) {
        //     return redirect()->back()->with(
        //         'error',
        //         'Mã giảm giá không hợp lệ.'
        //     );
        // }

        // Kiểm tra xem người dùng đã sử dụng voucher này chưa
        $isVoucherUsed = DB::table('voucher_uses')
            ->where('user_id', $user->id)
            ->where('voucher_id', $voucher->id)
            ->exists();

        if ($isVoucherUsed) {
            return redirect()->back()->with('error', 'Bạn đã sử dụng mã giảm giá này.');
        }

        // Kiểm tra xem có sản phẩm nào trong flash sale không
        $hasFlashSaleItem = $selectedCartItems->contains(function ($cartItem) {
            $flashSaleItem = FlashSaleItem::where('product_id', $cartItem->productVariant->product->id)
                ->whereHas('flashSale', function ($query) {
                    $query->where('start_time', '<=', now())
                        ->where('end_time', '>=', now())
                        ->where('status', 'active');
                })
                ->first();

            return $flashSaleItem !== null; // Nếu có sản phẩm trong Flash Sale, trả về true
        });

        if ($hasFlashSaleItem) {
            return redirect()->back()->with('error', 'Không thể sử dụng mã giảm giá cho sản phẩm đang trong Flash Sale.');
        }

        // Tính tổng giá trị của các sản phẩm đã chọn
        $totalPrice = $selectedCartItems->sum(function ($cartItem) {
            $flashSaleItem = FlashSaleItem::where('product_id', $cartItem->productVariant->product->id)
                ->whereHas('flashSale', function ($query) {
                    $query->where('start_time', '<=', now())
                        ->where('end_time', '>=', now())
                        ->where('status', 'active');
                })
                ->first();

            $finalPrice = $flashSaleItem ? $flashSaleItem->price : $cartItem->productVariant->product->price;
            return $finalPrice * $cartItem->quantity;
        });

        $discountAmount = ($totalPrice * $voucher->discount_percentage) / 100;

        if ($discountAmount > $voucher->max_discount) {
            $discountAmount = $voucher->max_discount;
        }

        if (
            $totalPrice >= $voucher->min_order_value
        ) {
            $discountAmount = min($totalPrice, $discountAmount);
        }

        // Lưu thông tin voucher đã sử dụng vào cơ sở dữ liệu
        DB::table('voucher_uses')->insert([
            'user_id' => $user->id,
            'voucher_id' => $voucher->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        session()->put('voucher_discount', [
            'voucher_code' => $voucher->name,
            'discount_percentage' => $voucher->discount_percentage,
            'min_order_value' => $voucher->min_order_value,
            'max_discount' => $voucher->max_discount,
            'status' => $voucher->status,
            'discount_amount' => $discountAmount
        ]);

        if ($voucher) {
            // Thông báo thành công
            return back()->with('success', 'Mã giảm giá đã được áp dụng. Giảm giá: ' . number_format($discountAmount) . ' VNĐ');
        } else {
            // Thông báo lỗi
            return redirect()->back()->with('error', 'Mã giảm giá không hợp lệ.');
        }
    }


    public function createOrder(Request $request)
    {
        $user = Auth::user();
        $cart = Cart::with('cartItems.productVariant')->where('user_id', $user->id)->first();

        // Lấy các ID sản phẩm được chọn từ request
        $selectedCartItemIds = $request->input('selectedCartItemIds', []);

        // Lọc ra các sản phẩm được chọn
        $selectedCartItems = $cart->cartItems->whereIn('id', $selectedCartItemIds);

        // Kiểm tra nếu không có sản phẩm được chọn
        if ($selectedCartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Vui lòng chọn sản phẩm để đặt hàng.');
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

        // Tính tổng tiền cho các sản phẩm đã chọn
        $totalPrice = $selectedCartItems->sum(function ($cartItem) {
            // Kiểm tra Flash Sale và tính giá bán nếu có
            $flashSaleItem = FlashSaleItem::where('product_id', $cartItem->productVariant->product->id)
                ->whereHas('flashSale', function ($query) {
                    $query->where('start_time', '<=', now())
                        ->where('end_time', '>=', now())
                        ->where('status', 'active');
                })
                ->first();

            // Nếu có Flash Sale thì lấy giá flash sale, nếu không lấy giá sản phẩm
            $finalPrice = $flashSaleItem ? $flashSaleItem->price : $cartItem->productVariant->product->price;
            return $finalPrice * $cartItem->quantity;
        });

        // Lấy discountAmount từ session (nếu có)
        $discountAmount = session()->has('voucher_discount') ? session()->get('voucher_discount')['discount_amount'] : 0;

        // Tính số tiền cần thanh toán
        $vnp_Amount = ($totalPrice - $discountAmount + 30000) * 100;

        // Truyền số tiền vào request để thanh toán
        $request->merge(['vnp_Amount' => $vnp_Amount]);

        // Gọi hàm thanh toán (thanh toán qua VNPay)
        return app(PaymentController::class)->vnpay_payment($request);
    }




    public function createOrderAfterPayment($cartId, $orderData)
    {
        // Lấy giỏ hàng từ ID
        $cart = Cart::with('cartItems.productVariant')->find($cartId);

        // Kiểm tra giỏ hàng
        if (!$cart) {
            return redirect()->route('checkout')->with('error', 'Giỏ hàng không tồn tại.');
        }

        // Lấy các ID sản phẩm đã chọn từ orderData
        $selectedCartItemIds = $orderData['selectedCartItemIds'] ?? [];
        $selectedCartItems = $cart->cartItems->whereIn('id', $selectedCartItemIds);

        // Kiểm tra nếu không có sản phẩm được chọn
        if ($selectedCartItems->isEmpty()) {
            return redirect()->route('checkout')->with('error', 'Giỏ hàng không có sản phẩm được chọn.');
        }

        // Gọi hàm để tạo đơn hàng sau khi thanh toán thành công
        return $this->createOrderOnline($cart, $orderData);
    }



    public function createOrderOnline($cart, $orderData)
    {
        $user = Auth::user();

        // Lấy các sản phẩm đã chọn từ giỏ hàng
        $selectedCartItems = $cart->cartItems->whereIn('id', $orderData['selectedCartItemIds']);

        // Tính tổng tiền cho các sản phẩm đã chọn
        $totalPrice = $selectedCartItems->sum(function ($item) {
            $flashSaleItem = FlashSaleItem::where('product_id', $item->productVariant->product->id)
                ->whereHas('flashSale', function ($query) {
                    $query->where('start_time', '<=', now())
                        ->where('end_time', '>=', now())
                        ->where('status', 'active');
                })
                ->first();

            $finalPrice = $flashSaleItem ? $flashSaleItem->price : $item->productVariant->product->price;
            return $finalPrice * $item->quantity;
        });

        // Lấy discountAmount từ session (nếu có)
        $discountAmount = session()->get('voucher_discount')['discount_amount'] ?? 0;

        // Tính tổng tiền sau khi trừ giảm giá và cộng phí giao hàng
        $finalTotal = $totalPrice - $discountAmount + 30000;

        // Tạo đơn hàng
        $order = Order::create([
            'user_id' => $user->id,
            'payment' => 2,  // Thanh toán online
            'order_date' => now(),
            'status' => 'Chờ xác nhận',
            'total_amount' => $finalTotal,
            'name_order' => $orderData['name_order'],
            'phone_order' => $orderData['phone_order'],
            'address_order' => $orderData['address_order'],
            'content_order' => $orderData['content_order'] ?? '',
        ]);

        // Lưu các sản phẩm trong đơn hàng và cập nhật tồn kho
        foreach ($selectedCartItems as $item) {
            $finalPrice = $item->productVariant->product->price;

            // Tạo sản phẩm trong đơn hàng
            OrderItem::create([
                'order_id' => $order->id,
                'product_variant_id' => $item->productVariant->id,
                'quantity' => $item->quantity,
                'price' => $finalPrice,
            ]);

            // Cập nhật tồn kho
            $item->productVariant->decrement('stock_quantity', $item->quantity);
        }

        // Xóa các sản phẩm đã chọn trong giỏ hàng
        $cart->cartItems()->whereIn('id', $orderData['selectedCartItemIds'])->delete();

        // Chuyển hướng đến trang cảm ơn
        return redirect()->route('thankyou')->with('success', 'Đặt hàng thành công.');
    }



    //thanh toán khi nhận hàng
    public function Order(Request $request)
    {
        $user = Auth::user();

        $cart = Cart::with('cartItems.productVariant.product')->where('user_id', $user->id)->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->route('cart.load')->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        // Lấy danh sách các mục giỏ hàng được chọn
        $selectedCartItemIds = $request->input('selectedCartItemIds', []);
        $selectedCartItems = $cart->cartItems->whereIn('id', $selectedCartItemIds);

        if ($selectedCartItems->isEmpty()) {
            return redirect()->route('cart.load')->with('error', 'Không có sản phẩm nào được chọn để đặt hàng.');
        }

        // Kiểm tra sản phẩm ngừng kinh doanh
        $inactiveItems = $selectedCartItems->filter(function ($cartItem) {
            return $cartItem->productVariant->product->status == 2;
        });

        if ($inactiveItems->count() > 0) {
            $inactiveProductNames = $inactiveItems->pluck('productVariant.product.name')->join(', ');
            return redirect()->route('cart.load')->with('error', 'Các sản phẩm sau đã ngừng kinh doanh: ' . $inactiveProductNames . '. Vui lòng xoá chúng khỏi giỏ hàng.');
        }

        // // Kiểm tra Flash Sale hết hạn
        // foreach ($selectedCartItems as $cartItem) {
        //     $flashSaleItem = FlashSaleItem::where('product_id', $cartItem->productVariant->product->id)
        //         ->whereHas('flashSale', function ($query) {
        //             $query->where('start_time', '<=', now())
        //                 ->where('end_time', '>=', now())
        //                 ->where('status', 'Đang diễn ra');
        //         })
        //         ->first();

        //     if (!$flashSaleItem) {
        //         return redirect()->back()->with('error_flash_sale', 'Flash Sale cho sản phẩm ' . $cartItem->productVariant->product->name . ' đã hết hạn. Bạn vẫn muốn tiếp tục ?');
        //     }
        // }
        // Kiểm tra Flash Sale hết hạn
        // $expiredFlashSales = [];

        // foreach ($selectedCartItems as $cartItem) {
        //     $flashSaleItem = FlashSaleItem::where('product_id', $cartItem->productVariant->product->id)
        //         ->whereHas('flashSale', function ($query) {
        //             $query->where('start_time', '<=', now())
        //                 ->where('end_time', '>=', now())
        //                 ->where('status', 'Đang diễn ra');
        //         })
        //         ->first();

        //     if (!$flashSaleItem) {
        //         $expiredFlashSales[] = $cartItem->productVariant->product->name;
        //     }
        // }

        // // Nếu có sản phẩm hết hạn Flash Sale, báo lỗi và cho phép người dùng quyết định
        // if (count($expiredFlashSales) > 0) {
        //     $expiredProducts = implode(', ', $expiredFlashSales);
        //     return redirect()->back()->with([
        //         'error_flash_sale' => "Flash Sale cho các sản phẩm sau đã hết hạn: $expiredProducts. Bạn vẫn muốn tiếp tục đặt hàng không?",
        //         'allow_continue' => true // Cờ để đánh dấu cho phép tiếp tục
        //     ]);
        // }


        // Tính tổng tiền
        $totalPrice = $selectedCartItems->sum(function ($cartItem) {
            $flashSaleItem = FlashSaleItem::where('product_id', $cartItem->productVariant->product->id)
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
        // Validate thông tin đơn hàng
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

        // Tạo đơn hàng
        $order = Order::create([
            'user_id' => $user->id,
            'payment' => 1,
            'order_date' => now(),
            'status' => 'Chờ xác nhận',
            'total_amount' => $totalPrice - $discountAmount + 30000,
            'name_order' => $request->name_order,
            'phone_order' => $request->phone_order,
            'address_order' => $request->address_order,
            'content_order' => $request->content_order,
        ]);

        // Tạo các mục đơn hàng
        foreach ($selectedCartItems as $item) {
            $productVariant = $item->productVariant;
            if (!$productVariant) {
                return redirect()->back()->with('error', 'Sản phẩm không tồn tại hoặc không có sẵn.');
            }

            // Kiểm tra số lượng tồn kho
            if ($productVariant->stock_quantity < $item->quantity) {
                return redirect()->back()->with('error', 'Sản phẩm ' . $productVariant->product->name . ' không đủ số lượng trong kho.');
            }

            // Trừ số lượng tồn kho
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
                'product_variant_id' => $productVariant->id,
                'quantity' => $item->quantity,
                'price' => $finalPrice,
            ]);
        }

        // Xóa các mục đã mua khỏi giỏ hàng
        $selectedCartItemIds = $request->input('selectedCartItemIds', []);

        // Xóa các sản phẩm đã được chọn khỏi giỏ hàng
        $cart->cartItems()->whereIn('id', $selectedCartItemIds)->delete();

        // Nếu giỏ hàng không còn sản phẩm nào, xóa luôn giỏ hàng
        if ($cart->cartItems()->count() === 0) {
            $cart->delete();
        }
        $order_item = OrderItem::where('order_id', $order->id)->get();
        Mail::to($user->email)->send(new mailOrder($order, $order_item));
        return redirect()->route('thankyou');
    }

    public function loadOrderUser()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->with('orderItems')->orderBy('id', 'desc')->get();
        $orders_pending = Order::where('user_id', $user->id)->where('status', 'Chờ xác nhận')->with('orderItems')->orderBy('id', 'desc')->get();
        $orders_vanchuyen = Order::where('user_id', $user->id)->where('status', 'Vận chuyển')->with('orderItems')->orderBy('id', 'desc')->get();
        $orders_chogiaohang = Order::where('user_id', $user->id)->where('status', 'Chờ giao hàng')->with('orderItems')->orderBy('id', 'desc')->get();
        $orders_hoanthanh = Order::where('user_id', $user->id)->where('status', 'Hoàn thành')->with('orderItems')->orderBy('id', 'desc')->get();
        $orders_dahuy = Order::where('user_id', $user->id)->where('status', 'Đã huỷ')->with('orderItems')->orderBy('id', 'desc')->get();
        $orders_danhan = Order::where('user_id', $user->id)->where('status', 'Đã nhận hàng')->with('orderItems')->orderBy('id', 'desc')->get();

        // Nếu bạn cần truyền sản phẩm vào view, ví dụ như lấy sản phẩm đầu tiên từ một đơn hàng nào đó:
        $product = Product::first();  // Chỉ ví dụ, bạn có thể chọn sản phẩm khác

        return view('client.order', compact('orders_dahuy', 'orders_pending', 'orders_vanchuyen', 'orders_chogiaohang', 'orders_hoanthanh', 'orders_danhan', 'orders', 'product'));
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

    public function cancelOrder($orderId, Request $request)
    {
        $order = Order::where('user_id', auth()->id())
            ->where('id', $orderId)
            ->first();

        if ($order) {
            // Nếu đơn hàng đã được xác nhận (status = 'confirmed'), không cho phép huỷ
            if ($order->status == 'Vận chuyển') {
                return redirect()->route("orders.loadUser")->with('error_' . $order->id, 'Không thể huỷ đơn hàng đã vận chuyển .');
            }
            if ($order->status == 'Chờ giao hàng') {
                return redirect()->route("orders.loadUser")->with('error_' . $order->id, 'Không thể huỷ đơn hàng chờ giao tới bạn .');
            }
            if ($order->status == 'Hoàn thành') {
                return redirect()->route("orders.loadUser")->with('error_' . $order->id, 'Không thể huỷ đơn hàng đã hoàn thành .');
            }

            $order->status = 'Đã huỷ';
            $order->save();

            return redirect()->route('orders.loadUser')->with('success', 'Đơn hàng đã được hủy.');
        }

        return redirect()->route("orders.loadUser")->with('error', 'Không thể hủy đơn hàng này.');
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

    public function reorder($orderId)
    {
        $order = Order::find($orderId);

        // Kiểm tra nếu đơn hàng tồn tại
        if ($order) {
            // Tạo hoặc lấy giỏ hàng của người dùng
            $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);

            // Lặp qua các sản phẩm trong đơn hàng và thêm chúng vào giỏ hàng
            foreach ($order->orderItems as $item) {
                // Kiểm tra nếu sản phẩm đã có trong giỏ hàng
                $existingItem = CartItem::where('cart_id', $cart->id)
                    ->where('product_variant_id', $item->productVariant->id)
                    ->first();

                if ($existingItem) {
                    // Nếu sản phẩm đã có trong giỏ hàng, chỉ cần tăng số lượng lên/-strong/-heart:>:o:-((:-h $existingItem->quantity += $item->quantity;
                    $existingItem->save();
                } else {
                    // Nếu chưa có, tạo mới item trong giỏ hàng
                    CartItem::create([
                        'cart_id' => $cart->id,
                        'product_variant_id' => $item->productVariant->id,
                        'quantity' => $item->quantity,
                        'price' => $item->productVariant->product->price,
                    ]);
                }
            }

            return redirect()->route('cart.load')->with('success', 'Đã thêm các sản phẩm vào giỏ hàng.');
        }

        return redirect()->route('orders.loadUser')->with('error', 'Đơn hàng không tồn tại.');
    }
}
