<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
     // Thống kê doanh thu
     public function revenue(Request $request)
     {
         $startDate = $request->input('start_date'); // Ngày bắt đầu
         $endDate = $request->input('end_date');     // Ngày kết thúc
 
         $revenue = DB::table('orders')
             ->whereBetween('order_date', [$startDate, $endDate])
             ->sum('total_amount');
 
         return response()->json(['revenue' => $revenue]);
     }

     // Thống kê user đặt hàng nhiều nhất
public function topUsers(Request $request)
{
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');
    $limit = $request->input('limit', 5); // Mặc định lấy 5 user

    $topUsers = DB::table('orders')
        ->select('users.id', 'users.name', DB::raw('COUNT(orders.id) as order_count'))
        ->join('users', 'orders.user_id', '=', 'users.id')
        ->whereBetween('orders.order_date', [$startDate, $endDate])
        ->groupBy('users.id', 'users.name')
        ->orderByDesc('order_count')
        ->take($limit)
        ->get();

    return response()->json(['top_users' => $topUsers]);
}

// Thống kê sản phẩm bán chạy nhất
public function topProducts(Request $request)
{
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');
    $limit = $request->input('limit', 5); // Mặc định lấy 5 sản phẩm

    $topProducts = DB::table('order_items')
        ->select('products.id', 'products.name', DB::raw('SUM(order_items.quantity) as total_sold'))
        ->join('product_variants', 'order_items.product_variant_id', '=', 'product_variants.id')
        ->join('products', 'product_variants.product_id', '=', 'products.id')
        ->whereBetween('order_items.created_at', [$startDate, $endDate])
        ->groupBy('products.id', 'products.name')
        ->orderByDesc('total_sold')
        ->take($limit)
        ->get();

    return response()->json(['top_products' => $topProducts]);
}

}
