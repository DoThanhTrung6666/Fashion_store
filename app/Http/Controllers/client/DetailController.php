<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    // Hiển thị chi tiết sản phẩm
    public function show($id){
        // Tìm sản phẩm theo id
        $detail = Product::with('variants', 'category')->where('status', 1)->find($id);
        if ($detail) {
            // Tăng số lượt xem của sản phẩm
            $detail->views += 1;
            $detail->save();
        }

        if (!$detail) {
            $detail1 = Product::find($id);
            if ($detail1 && $detail1->status == 2) {
                return redirect()->route('home');
            }
        }

        // dd($detail);
        $variants = $detail->variants;

        $flashSales = FlashSaleItem::with('flashSale')
        ->where('product_id', $detail->id)
        ->whereHas('flashSale', function ($query) {
            $query->where('start_time', '<=', now())
                  ->where('end_time', '>=', now());
        })
        ->first();
        // sản phẩm cùng loại

        $relatedProducts = Product::with('variants', 'category')
            ->where('category_id', $detail->category_id)  // Lọc theo category_id của sản phẩm hiện tại
            ->where('id', '!=', $detail->id)  // Loại bỏ sản phẩm hiện tại khỏi danh sách
            ->take(4)  // Lấy tối đa 4 sản phẩm cùng loại
            ->get();

        // Lấy các bình luận của sản phẩm
        $comments = Comment::whereIn('product_variant_id', $variants->pluck('id'))
        ->with('user')
        ->get();

    // Trả về view với các dữ liệu đã truy vấn
    return view('client.productDetail', compact('comments', 'relatedProducts', 'variants', 'flashSales', 'detail'));
    }


    // Lưu bình luận
    // public function storeComment(Request $request, $productId)
    // {
    //     // Kiểm tra dữ liệu đầu vào
    //     $validated = $request->validate([
    //         'rating' => 'required|integer|between:1,5', // Đánh giá từ 1 đến 5
    //         'content' => 'required|string|max:1000', // Nội dung bình luận tối đa 1000 ký tự
    //     ]);

    //     // Kiểm tra nếu người dùng đã đăng nhập
    //     if (!auth()->check()) {
    //         return redirect()->route('login')->with('error', 'Please login to leave a review.');
    //     }

    //     // Lưu bình luận vào cơ sở dữ liệu
    //     Comment::create([
    //         'user_id' => auth()->id(), // Lấy id của người dùng hiện tại
    //         'product_id' => $productId, // Id của sản phẩm
    //         'rating' => $validated['rating'], // Đánh giá của người dùng
    //         'content' => $validated['content'], // Nội dung bình luận
    //     ]);


    //     // Trả về trang trước với thông báo thành công
    //     return back()->with('success', 'Your review has been submitted!');

    // }

    public function storeComment(Request $request, $productId)
{
    // Kiểm tra dữ liệu đầu vào
    $validated = $request->validate([
        'rating' => 'required|integer|between:1,5', // Đánh giá từ 1 đến 5
        'content' => 'required|string|max:1000', // Nội dung bình luận tối đa 1000 ký tự
    ]);

    // Kiểm tra nếu người dùng đã đăng nhập
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'Please login to leave a review.');
    }

    // Kiểm tra xem người dùng có đơn hàng hoàn thành với sản phẩm này không
    $user = auth()->user();
    $hasCompletedOrder = Order::where('user_id', $user->id)
        ->where('status', 'Hoàn thành') // Kiểm tra trạng thái đơn hàng là "Hoàn thành"
        ->whereHas('orderItems', function ($query) use ($productId) {
            $query->where('product_id', $productId); // Kiểm tra xem sản phẩm có trong đơn hàng không
        })
        ->exists();

    if (!$hasCompletedOrder) {
        return redirect()->back()->with('error', 'Bạn chỉ có thể bình luận khi đã hoàn thành đơn hàng với sản phẩm này.');
    }

    // Lưu bình luận vào cơ sở dữ liệu
    Comment::create([
        'user_id' => auth()->id(), // Lấy id của người dùng hiện tại
        'product_id' => $productId, // Id của sản phẩm
        'rating' => $validated['rating'], // Đánh giá của người dùng
        'content' => $validated['content'], // Nội dung bình luận
    ]);

    // Trả về trang trước với thông báo thành công
    return back()->with('success', 'Your review has been submitted!');
}

}
