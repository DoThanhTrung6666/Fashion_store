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
            })->filter();
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

        // Validate người dùng đăng nhập
        if (!$user) {
            return redirect()->back()->with('error', 'Vui lòng đăng nhập');
        }

        // Validate các thông tin cần thiết
        if (!$request->has('color_id') || !$request->has('size_id')) {
            return redirect()->back()->with('error', 'Vui lòng chọn đầy đủ màu sắc và kích cỡ.');
        }

        $productId = $request->input('product_id');
        $colorId = $request->input('color_id');
        $sizeId = $request->input('size_id');
        $quantity = $request->input('quantity');

        if ($quantity <= 0) {
            return redirect()->back()->with('error', 'Số lượng phải lớn hơn 0');
        }

        // Tìm product_variant
        $productVariant = ProductVariant::where('product_id', $productId)
            ->where('color_id', $colorId)
            ->where('size_id', $sizeId)
            ->first();

        if (!$productVariant) {
            return redirect()->back()->with('error', 'Biến thể không tồn tại');
        }

        if ($quantity > $productVariant->stock_quantity) {
            return redirect()->back()->with('error', 'Sản phẩm vượt quá số lượng tồn kho. Còn lại ' . $productVariant->stock_quantity . ' sản phẩm');
        }

        // Kiểm tra giỏ hàng
        $cart = Cart::firstOrCreate(
            ['user_id' => auth()->id(), 'status' => 1],
            ['created_at' => now(), 'updated_at' => now()]
        );

        // Kiểm tra cartItem
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_variant_id', $productVariant->id)
            ->first();

        $totalQuantityInCart = $cartItem ? $cartItem->quantity : 0;

        // Kiểm tra tổng số lượng có vượt quá tồn kho không
        if ($totalQuantityInCart + $quantity > $productVariant->stock_quantity) {
            return redirect()->back()->with('error', 'Số lượng sản phẩm trong giỏ hàng vượt quá tồn kho. Còn lại ' . $productVariant->stock_quantity . ' sản phẩm');
        }

        // Nếu vượt qua tất cả kiểm tra, cập nhật hoặc thêm mới sản phẩm vào giỏ hàng
        if ($cartItem) {
            $cartItem->update([
                'quantity' => $totalQuantityInCart + $quantity,
                'updated_at' => now()
            ]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_variant_id' => $productVariant->id,
                'quantity' => $quantity,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng');
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

    // cập nhật số lượng
    // public function updateQuantityCart(Request $request , $id){
    //     $validated = $request->validate([
    //         'quantity' => 'required|integer|min:1|max:10'
    //     ]);
    //     $cartItems = CartItem::findOrFail($id);
    //     if($cartItems->cart->user_id !== auth()->id()){
    //         return redirect()->back()->with('error','Không thể  cập nhật sản phẩm này');
    //     }
    //     $productVariant = ProductVariant::where('product_id',$cartItems->productVariant->product_id)
    //         ->where('color_id',$cartItems->productVariant->color_id)
    //         ->where('size_id',$cartItems->productVariant->size_id)
    //         ->first();
    //     // dd($cartItems->productVariant->product_id);
    //     // dd($cartItems->productVariant->color_id);
    //     if(!$productVariant){
    //         return redirect()->back()->with('error','Không tìm thấy sản phẩm');
    //     }
    //     if($validated['quantity']>$productVariant->stock_quantity){
    //         return redirect()->back()->with('error','Số lượng yêu cầu vượt quá tồn kho. Chỉ còn' .$productVariant->stock_quantity.'sản phẩm');
    //     }
    //     $cartItems->quantity = $validated['quantity'];
    //     $cartItems->save();
    //     return redirect()->back()->with('success','Cập nhật số lượng thành công');
    // }

    // xử lí mua hàng lại
    public function increaseQuantity($id)
{
    $cartItem = CartItem::findOrFail($id);

    // Kiểm tra quyền sở hữu giỏ hàng
    if ($cartItem->cart->user_id !== auth()->id()) {
        return redirect()->back()->with('error', 'Không thể cập nhật sản phẩm này.');
    }

    // Kiểm tra tồn kho
    $productVariant = ProductVariant::where('product_id', $cartItem->productVariant->product_id)
        ->where('color_id', $cartItem->productVariant->color_id)
        ->where('size_id', $cartItem->productVariant->size_id)
        ->first();

    if (!$productVariant || $cartItem->quantity + 1 > $productVariant->stock_quantity) {
        return redirect()->back()->with('error', 'Số lượng yêu cầu vượt quá tồn kho.');
    }

    // Tăng số lượng
    $cartItem->quantity++;
    $cartItem->save();

    return redirect()->back()->with('success', 'Cập nhật số lượng thành công.');
}

public function decreaseQuantity($id)
{
    $cartItem = CartItem::findOrFail($id);

    // Kiểm tra quyền sở hữu giỏ hàng
    if ($cartItem->cart->user_id !== auth()->id()) {
        return redirect()->back()->with('error', 'Không thể cập nhật sản phẩm này.');
    }

    // Giảm số lượng (tối thiểu là 1)
    if ($cartItem->quantity > 1) {
        $cartItem->quantity--;
        $cartItem->save();
        return redirect()->back()->with('success', 'Cập nhật số lượng thành công.');
    }

    return redirect()->back()->with('error', 'Số lượng tối thiểu phải là 1.');
}

}
