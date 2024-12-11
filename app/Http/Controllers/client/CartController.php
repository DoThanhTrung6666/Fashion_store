<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    //Hiển thị giỏ hàng
    public function index()
    {
        // Lấy giỏ hàng của người dùng với trạng thái đã hoàn thành (status = 1)
        $cart = Cart::where('user_id', auth()->id())
            ->where('status', 1)
            ->with('cartItems.productVariant.product') // Eager load để lấy thông tin sản phẩm
            ->first();

        // Duyệt qua tất cả các sản phẩm trong giỏ hàng và kiểm tra flash sale
        if ($cart !== null) {
            $cartItemsWithSaleInfo = $cart->cartItems->map(function ($cartItem) {
                // Kiểm tra nếu sản phẩm này có tham gia Flash Sale
                $flashSale = FlashSaleItem::where('product_id', $cartItem->productVariant->product->id)
                    ->whereHas('flashSale', function ($query) {
                        $query->where('start_time', '<=', now())
                            ->where('end_time', '>=', now())
                            ->where('status', 'Đang diễn ra');
                    })
                    ->first();

                // Trả về thông tin sản phẩm và trạng thái Flash Sale của sản phẩm đó
                return [
                    'cartItem' => $cartItem,  // Sản phẩm trong giỏ hàng
                    'isOnFlashSale' => $flashSale ? true : false, // Trạng thái Flash Sale
                    'flashSale' => $flashSale, // Thông tin Flash Sale nếu có
                    'finalPrice' => $flashSale ? $flashSale->price : $cartItem->productVariant->product->price,
                ];
            });
            $totalAmount = $cartItemsWithSaleInfo->sum(function ($item) {
                return $item['finalPrice'] * $item['cartItem']->quantity;
            });

            // $totalDiscount = $cartItemsWithSaleInfo->sum(function ($item) {
            //     if ($item['isOnFlashSale']) {
            //         return ($item['originalPrice'] - $item['finalPrice']) * $item['cartItem']->quantity;
            //     }
            //     return 0; // Không giảm nếu không thuộc Flash Sale
            // });
            session()->put('voucher_discount', [
                'voucher_code' => '',
                'discount_percentage' => 0,
                'min_order_value' => 0,
                'max_discount' => 0,
                'status' => 0,
                'discount_amount' => 0 // Đặt giá trị giảm là 0
            ]);
            return view('client.cart', compact('totalAmount', 'cart', 'cartItemsWithSaleInfo'));
        } else {
            echo "";
        }


        // Trả về view với thông tin giỏ hàng và Flash Sale
        return view('client.cart', compact('cart'));
    }

    public function addToCart(Request $request)
    {
        $user = Auth::user();
        // validate
        if (!$user) {
            return redirect()->back()->with('error', 'Vui lòng đăng nhập');
        }
        if (!$request->has('color_id') || !$request->has('size_id')) {
            return redirect()->back()->with('error', 'Vui lòng chọn đầy đủ màu sắc và kích cỡ.');
        }
        //lấy các thông tin từ form lên để so sánh với product_variant

        $productId = $request->input('product_id');
        $colorId = $request->input('color_id');
        $sizeId = $request->input('size_id');
        $quantity = $request->input('quantity');
        if ($request->quantity <= 0) {
            return redirect()->back()->with('error', 'Số lượng phải lớn hơn 0');
        }

        // sau đó tìm theo product_variant
        $productVariant = ProductVariant::where('product_id', $productId)
            ->where('color_id', $colorId)
            ->where('size_id', $sizeId)
            ->first();
        if (!$productVariant) {
            return redirect()->back()->with('error', 'Biến thể không tồn tại');
        }
        if ($quantity > $productVariant->stock_quantity) {
            return redirect()->back()->with('error', 'Sản phẩm quá số lượng.Còn ' . $productVariant->stock_quantity . 'sản phẩm');
        }
        // // Sau khi kiểm tra, tiến hành trừ số lượng trong kho
        //     $productVariant->stock_quantity -= $quantity;
        //     $productVariant->save(); // Lưu lại sự thay đổi
        // sau khi so sánh xong thì kiểm tra nếu người dùng đã có giỏ hàng thì load giỏ hàng theo user_id
        $cart = Cart::firstOrCreate(
            ['user_id' => auth()->id(), 'status' => 1],
            ['created_at' => now(), 'updated_at' => now()]
        );

        // kiểm tra nếu có cartItem thì tiến hành cập nhật ở bước thứ 2
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_variant_id', $productVariant->id)
            ->first();
        // bước thứ 2
        if ($cartItem) {
            // nếu sản phẩm đã có , cập nhật số lượng
            $cartItem->update([
                'quantity' => $cartItem->quantity + $quantity,
                'updated_at' => now()
            ]);
        } else {
            // nếu chưa có sản phẩm thì tiến hành thêm mới
            CartItem::create([
                'cart_id' => $cart->id,
                'product_variant_id' => $productVariant->id,
                'quantity' => $request->quantity,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        // tính tổng tiền
        return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng');
        // return route('cart.load');
    }

    // Xoá sản phẩm khỏi giỏ
    public function remove($id)
    {
        // tìm tới item để xoá theo id
        $cartItem = CartItem::findOrFail($id);
        // $productVariant = $cartItem->productVariant;

        // // Sau khi xóa sản phẩm khỏi giỏ hàng, tăng lại số lượng trong kho
        // $productVariant->stock_quantity += $cartItem->quantity;
        // $productVariant->save(); // Lưu lại sự thay đổi
        // sau khi tìm xong tiến hành xoá
        $cartItem->delete();
        return redirect()->route('cart.load')->with('success', 'Sản phẩm đã được xoá khỏi giỏ hàng');
    }


    // Thanh toán giỏ hàng đã chọn
    public function proceedToCheckout(Request $request)
    {
        $selectedCartItemIds = $request->input('cart_item_ids', []);

        if (empty($selectedCartItemIds)) {
            return redirect()->route('cart.load')->with('error', 'Vui lòng chọn ít nhất một sản phẩm để thanh toán.');
        }

        return redirect()->route('checkout', ['selectedCartItemIds' => $selectedCartItemIds]);
    }
}
