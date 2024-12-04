<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class thongkeController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());
    
        // Dữ liệu doanh thu
        $revenueData = Order::selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    
        $revenueDates = $revenueData->pluck('date');
        $revenueValues = $revenueData->pluck('revenue');
    
        // Người dùng đặt hàng nhiều nhất
        $topUsers = Order::select('user_id', \DB::raw('COUNT(*) as order_count'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('user_id')
            ->orderByDesc('order_count')
            ->take(5)
            ->with(['user:id,name'])
            ->get();
    
        // Sản phẩm bán chạy nhất
        $topProducts = OrderItem::select('product_variant_id', \DB::raw('SUM(quantity) as total_sold'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('product_variant_id')
            ->orderByDesc('total_sold')
            ->take(5)
            ->with(['product:id,name'])
            ->get();
    
        return view('admin.dashboard.index', compact(
            'startDate', 'endDate', 'revenueDates', 'revenueValues', 'topUsers', 'topProducts'
        ));
    }
    
}

