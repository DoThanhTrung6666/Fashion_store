<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
// use Illuminate\Support\ServiceProvider;
use App\Models\CartItem;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        // Paginator::useBootstrapThree();
        // Đăng ký một view composer cho tất cả các view
        View::composer('*', function ($view) {
            // Kiểm tra xem người dùng có đăng nhập không
            if (Auth::check()) {
                // Tính tổng số lượng sản phẩm trong giỏ hàng của người dùng hiện tại
                $cartCount = CartItem::whereHas('cart', function ($query) {
                    $query->where('user_id', Auth::id());
                })->sum('quantity');  // Tính tổng số lượng sản phẩm từ cart_items
                // dd($cartCount);
                // Chia sẻ biến cartCount với tất cả các view
                $view->with('cartCount', $cartCount);
            } else {
                // Nếu người dùng chưa đăng nhập, giỏ hàng mặc định là 0 sản phẩm
                $view->with('cartCount', 0);
            }
        });
    }
}
