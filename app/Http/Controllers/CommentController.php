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
    
    


public function destroy(string $id)
{
    $comment = Comment::find($id);
    if (!$comment) {
        return redirect()->back()->with('errors', 'Bình luận không tồn tại!');
    }
    $comment->delete();
    return redirect()->back()->with('success', 'Xóa bình luận thành công!');
}

public function store(Request $request, $productId)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'content' => 'required|string',
        'rating' => 'required|integer|min:1|max:5',
    ]);

    $product = Product::findOrFail($productId);

    Comment::create([
        'product_id' => $productId,
        'user_id' => auth()->id(), // Nếu người dùng đã đăng nhập
        'content' => $validated['content'],
        'rating' => $validated['rating'],
    ]);

    return redirect()->route('products.show', $productId)->with('success', 'Bình luận của bạn đã được gửi');
}


}
