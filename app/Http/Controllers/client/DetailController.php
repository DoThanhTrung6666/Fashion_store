<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\FlashSale;
use App\Models\Product;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    // Hiển thị chi tiết sản phẩm
    public function show($id){
        // Tìm sản phẩm theo id
        $detail = Product::with('variants','category')->findOrFail($id);
        $variants = $detail->variants;
        $flashSale = FlashSale::where('product_id', $detail->id)
            ->where('start_time','<=',now())
            ->where('end_time' , '>=' ,now())
            ->first();
    
        // Sản phẩm cùng loại
        $relatedProducts = Product::with('variants', 'category')
            ->where('category_id', $detail->category_id)  // Lọc theo category_id của sản phẩm hiện tại
            ->where('id', '!=', $detail->id)  // Loại bỏ sản phẩm hiện tại khỏi danh sách
            ->take(4)  // Lấy tối đa 4 sản phẩm cùng loại
            ->get();
    
        // Lấy các bình luận của sản phẩm
        $comments = Comment::where('product_id', $id)->with('user')->get();
    
        // Trả về view với các dữ liệu đã truy vấn
        return view('client.productDetail', compact('comments', 'relatedProducts', 'variants', 'flashSale', 'detail'));
    }
    

    // Lưu bình luận
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
