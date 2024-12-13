<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;

use function Laravel\Prompts\error;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::withCount('comments')->get();
        return view('admin.comment.index', compact('products'));

    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     $product = Product::query()->find($id);
    //     if (!$product) {
    //         return redirect()->back()->with('errors', 'Sản phẩm không tồn tại!');
    //     }
    //     $comments = $product->comments;
    //     return view('admin.comment.show', compact('comments'));
    // }

    public function show(string $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return redirect()->back()->with('errors', 'Sản phẩm không tồn tại!');
        }
    
        // Eager load user để lấy tên người dùng
        $comments = $product->comments()->with('user')->get();
    
        return view('admin.comment.show', compact('comments'));
    }
    
    public function showCommentForm($productId)
    {
        // Lấy thông tin sản phẩm
        $product = Product::find($productId);
        if (!$product) {
            return redirect()->route('home')->with('error', 'Sản phẩm không tồn tại');
        }
    
        // Hiển thị trang bình luận
        return view('client.comment', compact('product'));
    }
    
    
    
    

    


public function destroy(string $id)
{
    $comment = Comment::find($id);
    if (!$comment) {
        return redirect()->back()->with('errors', 'Bình luận không tồn tại!');
    }
    $comment->delete();
    return redirect()->back()->with('success', 'Xóa bình luận thành công!');
}

// public function store(Request $request, $productId)
// {
//     // Validate input
//     $validated = $request->validate([
//         'content' => 'required|string',
//         'rating' => 'required|integer|between:0,5',  // Cho phép giá trị rating từ 0 đến 5
//     ]);

//     // Lấy thông tin sản phẩm
//     $product = Product::findOrFail($productId);

//     // Lưu bình luận vào cơ sở dữ liệu
//     Comment::create([
//         'product_id' => $productId,
//         'user_id' => auth()->id(),
//         'content' => $validated['content'],
//         'rating' => $validated['rating'],
//     ]);

//     // Lấy đơn hàng từ sản phẩm
//     $order = $product->order;  // Lấy đơn hàng liên quan đến sản phẩm

//     if ($order) {
//         // Nếu có đơn hàng, redirect về trang chi tiết đơn hàng
//         return redirect()->route('orders.show', ['orderId' => $order->id])
//             ->with('success', 'Bình luận của bạn đã được gửi');
//     }

//     // Nếu không có đơn hàng, trả về một thông báo lỗi hoặc trang lỗi
//     return redirect()->route('orders.loadUser')
//         ->with('error', 'Không tìm thấy đơn hàng liên quan.');
// }

public function store(Request $request, $productId)
{
    // Validate input
    $validated = $request->validate([
        'content' => 'required|string',
        'rating' => 'required|integer|between:0,5',  // Cho phép giá trị rating từ 0 đến 5
    ]);

    // Lấy thông tin sản phẩm
    $product = Product::findOrFail($productId);

    // Kiểm tra xem người dùng đã bình luận sản phẩm này chưa
    $existingComment = Comment::where('user_id', auth()->id())
        ->where('product_id', $productId)
        ->exists();

    if ($existingComment) {
        return redirect()->back()->with('error', 'Bạn đã bình luận sản phẩm này trước đó.');
    }

    // Lưu bình luận vào cơ sở dữ liệu
    Comment::create([
        'product_id' => $productId,
        'user_id' => auth()->id(),
        'content' => $validated['content'],
        'rating' => $validated['rating'],
    ]);

    // Lấy đơn hàng từ sản phẩm
    $order = $product->order;  // Lấy đơn hàng liên quan đến sản phẩm

    if ($order) {
        // Nếu có đơn hàng, redirect về trang chi tiết đơn hàng
        return redirect()->route('orders.show', ['orderId' => $order->id])
            ->with('success', 'Bình luận của bạn đã được gửi.');
    }

    // Nếu không có đơn hàng, trả về một thông báo lỗi hoặc trang lỗi
    return redirect()->route('orders.loadUser')
        ->with('error', 'Không tìm thấy đơn hàng liên quan.');
}





}
