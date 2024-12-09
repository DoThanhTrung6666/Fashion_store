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
//     $validated = $request->validate([
//         'name' => 'required|string|max:255',
//         'email' => 'required|email',
//         'content' => 'required|string',
//         'rating' => 'required|integer|min:1|max:5',
//     ]);

//     $product = Product::findOrFail($productId);

//     Comment::create([
//         'product_id' => $productId,
//         'user_id' => auth()->id(), // Nếu người dùng đã đăng nhập
//         'content' => $validated['content'],
//         'rating' => $validated['rating'],
//     ]);

//     return redirect()->route('products.show', $productId)->with('success', 'Bình luận của bạn đã được gửi');
// }

// Trong CommentController, sau khi lưu bình luận
// app/Http/Controllers/Client/CommentController.php

// app/Http/Controllers/Client/CommentController.php

// app/Http/Controllers/Client/CommentController.php

// public function store(Request $request, $productId)
// {
//     $validated = $request->validate([
//         'content' => 'required|string',
//         'rating' => 'required|integer|min:1|max:5',
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

//     // Lấy đơn hàng liên kết với sản phẩm
//     $order = $product->order; // Lấy đơn hàng từ mối quan hệ

//     // Kiểm tra nếu không tìm thấy đơn hàng
//     if (!$order) {
//         return redirect()->back()->with('error', 'Không tìm thấy đơn hàng của sản phẩm!');
//     }

//     // Sau khi bình luận xong, quay lại trang đơn hàng
//     return redirect()->route('order.show', ['orderId' => $order->id])->with('success', 'Bình luận của bạn đã được gửi');
// }

// app/Http/Controllers/CommentController.php

// app/Http/Controllers/CommentController.php

// app/Http/Controllers/CommentController.php

// app/Http/Controllers/CommentController.php

public function store(Request $request, $productId)
{
    // Validate input
    $validated = $request->validate([
        'content' => 'required|string',
        'rating' => 'required|integer|between:0,5',  // Cho phép giá trị rating từ 0 đến 5
    ]);

    // Lấy thông tin sản phẩm
    $product = Product::findOrFail($productId);

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
            ->with('success', 'Bình luận của bạn đã được gửi');
    }

    // Nếu không có đơn hàng, trả về một thông báo lỗi hoặc trang lỗi
    return redirect()->route('home')
        ->with('error', 'Không tìm thấy đơn hàng liên quan.');
}











}
