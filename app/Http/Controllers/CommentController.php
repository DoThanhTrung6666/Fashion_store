<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

use function Laravel\Prompts\error;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Lấy các đơn hàng có bình luận
        $orders = Order::whereHas('comments', function ($query) {
            $query->whereNotNull('rating'); // Kiểm tra xem có bình luận với rating không
        })
        ->with('orderItems.productVariant.product', 'comments') // Eager load các quan hệ cần thiết
        ->get();
    
        return view('admin.comment.index', compact('orders'));
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

    public function show($order_id, $product_id, $product_variant_id)
    {
        $comments = Comment::where('order_id', $order_id)
                           ->where('product_variant_id', $product_variant_id)
                           ->get();
        
        return view('admin.comment.show', compact('comments'));
    }
    
    
    
    
    public function showCommentForm($orderId)
    {
        // Lấy thông tin đơn hàng theo order_id
        $order = Order::find($orderId);
        if (!$order) {
            return redirect()->route('home')->with('error', 'Đơn hàng không tồn tại');
        }
    
        // Lấy danh sách các sản phẩm hoặc biến thể sản phẩm từ đơn hàng
        $orderItems = $order->orderItems; // Giả sử quan hệ giữa Order và OrderItem đã được định nghĩa
    
        // Lấy product_variant_id từ orderItems (ví dụ lấy từ sản phẩm đầu tiên)
        $product_variant_id = $orderItems->first()->productVariant->id ?? null;
    
        // Chuyển tới trang comment.blade.php với dữ liệu đơn hàng và các item
        return view('client.comment', compact('order', 'orderItems', 'product_variant_id'));
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

public function store(Request $request, $orderId)
{
    // Validate input
    $validated = $request->validate([
        'content' => 'required|string',
        'rating' => 'required|integer|between:0,5', // Cho phép giá trị rating từ 0 đến 5
    ]);

    // Lấy thông tin đơn hàng
    $order = Order::with('orderItems.productVariant')->findOrFail($orderId);
    

    // Lấy sản phẩm đầu tiên từ danh sách orderItems
    $productVariant = $order->orderItems->first()->productVariant ?? null;

    // Kiểm tra nếu không tìm thấy biến thể sản phẩm
    if (!$productVariant) {
        return redirect()->back()->with('error', 'Không tìm thấy sản phẩm trong đơn hàng.');
    }
     // Kiểm tra nếu đã đánh giá sản phẩm này
$existingComment = Comment::where('user_id', auth()->id())
    ->where('order_id', $orderId)
    ->where('product_variant_id', $productVariant->id) // Sử dụng $productVariant->id để kiểm tra
    ->exists();

if ($existingComment) {
    // Nếu đã đánh giá cùng sản phẩm trong đơn hàng, trả về trang orders.blade.php với thông báo
    return redirect()->route('orders.loadUser')->with('alert', 'Quý khách chỉ có thể đánh giá sản phẩm này 1 lần trong đơn hàng.');
}


    // Lưu bình luận vào cơ sở dữ liệu
    Comment::create([
        'product_variant_id' => $productVariant->id,
        'user_id' => auth()->id(),
        'content' => $validated['content'],
        'rating' => $validated['rating'],
        'order_id' => $orderId,
    ]);

    // Trả về thông báo thành công và chuyển hướng
    return redirect()->route('orders.loadUser', ['orderId' => $orderId])
        ->with('success', 'Cảm ơn quý khách đã mua hàng.');
}






}
