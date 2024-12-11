<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    //
    public function index(){
        $user = Auth::user();
        $favorites = $user -> favorites;
        return view('client.favorite',compact('favorites'));
    }

    public function addFavorite($productId)
{
    $user = Auth::user();

    // Kiểm tra qua relationship query thay vì Collection
    if ($user->favorites()->where('product_id', $productId)->exists()) {
        return redirect()->back()->with('error', 'Sản phẩm này đã có trong danh sách yêu thích');
    }

    $user->favorites()->attach($productId);
    return redirect()->route('favorites.index')->with('success', 'Sản phẩm đã được thêm vào yêu thích');
}
public function deleteFavorite($productId)
{
    $user = Auth::user();

    // Kiểm tra nếu quan hệ favorites null hoặc không chứa productId
    if (!$user->favorites || !$user->favorites->contains($productId)) {
        return redirect()->back()->with('error', 'Sản phẩm không có trong danh sách yêu thích');
    }

    // Sử dụng detach để xóa trong quan hệ nhiều-nhiều
    $user->favorites()->detach($productId);

    return redirect()->back()->with('success', 'Sản phẩm đã bị bỏ khỏi danh sách yêu thích');
}

}
