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
    public function show(string $id)
    {
        $product = Product::query()->find($id);
        if (!$product) {
            return redirect()->back()->with('errors', 'Sản phẩm không tồn tại!');
        }
        $comments = $product->comments;
        return view('admin.comment.show', compact('comments'));
    }

    public function destroy(string $id)
    {
        $comment = Comment::query()->find($id);
        if (!$comment) {
            return redirect()->back()->with('errors', 'Sản phẩm không tồn tại!');
        }
        $comment->delete();
        return redirect()->back()->with('success', 'Xóa thành công');
    }
}
