<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\FlashSaleItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class thongkeController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());

         // Doanh thu trong ngày
         $todayRevenue = Order::whereDate('created_at', today())
         ->sum('total_amount');

     
     
     // Doanh thu theo tháng
     $currentMonthRevenue = Order::whereYear('created_at', now()->year)
 ->whereMonth('created_at', now()->month)
 ->sum('total_amount');

$formattedCurrentMonthRevenue = number_format($currentMonthRevenue, 0, ',', '.') . ' đ';



     // Tổng đơn hàng trong tuần
     $weeklyOrders = Order::whereBetween('created_at', [
         now()->startOfWeek(),
         now()->endOfWeek()
     ])->count();

     // Tổng đơn hàng
    $totalOrders = Order::count();

    // Tổng sản phẩm
    $totalProducts = Product::count();

    // Tổng sản phẩm đã bán
    $totalProductsSold = OrderItem::sum('quantity');

     // Tổng khách hàng đặt hàng
     $totalCustomers = User::whereHas('orders')->count();

     // Tổng sản phẩm đang sale (ví dụ, nếu có cột 'is_on_sale')
     $totalProductsOnSale = FlashSaleItem::distinct('product_id')->count('product_id');

        
        if ($startDate === $endDate) {
            // Lọc trong cùng một ngày
            $revenueData = Order::selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue')
                ->whereDate('created_at', $startDate) // Lọc theo ngày cụ thể
                ->groupBy('date')
                ->orderBy('date')
                ->get();
            
            $topUsers = Order::select('user_id', \DB::raw('COUNT(*) as order_count'))
                ->whereDate('created_at', $startDate)
                ->groupBy('user_id')
                ->orderByDesc('order_count')
                ->take(5)
                ->with(['user:id,name'])
                ->get();

            // Sản phẩm bán chạy nhất
            $topProducts = OrderItem::select('products.id as product_id', 'products.name as product_name', \DB::raw('SUM(order_items.quantity) as total_sold'))
                ->join('product_variants', 'order_items.product_variant_id', '=', 'product_variants.id')
                ->join('products', 'product_variants.product_id', '=', 'products.id')
                ->whereDate('order_items.created_at', $startDate)
                ->groupBy('products.id', 'products.name')
                ->orderByDesc('total_sold')
                ->take(5)
                ->get();
                
        } else {
            // Lọc trong khoảng thời gian
            $revenueData = Order::selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue')
                ->whereBetween('created_at', [$startDate, $endDate]) // Lọc theo khoảng ngày
                ->groupBy('date')
                ->orderBy('date')
                ->get();
            
            $topUsers = Order::select('user_id', \DB::raw('COUNT(*) as order_count'))
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy('user_id')
                ->orderByDesc('order_count')
                ->take(5)
                ->with(['user:id,name'])
                ->get();

            $topProducts = OrderItem::select('products.id as product_id', 'products.name as product_name', \DB::raw('SUM(order_items.quantity) as total_sold'))
                ->join('product_variants', 'order_items.product_variant_id', '=', 'product_variants.id')
                ->join('products', 'product_variants.product_id', '=', 'products.id')
                ->whereBetween('order_items.created_at', [$startDate, $endDate])
                ->groupBy('products.id', 'products.name')
                ->orderByDesc('total_sold')
                ->take(5)
                ->get();
        }
        $revenueDates = $revenueData->pluck('date');
        $revenueValues = $revenueData->pluck('revenue');

        return view('admin.dashboard.index', compact(
            'startDate',
            'totalCustomers',
            'weeklyOrders',
            'formattedCurrentMonthRevenue',
            'todayRevenue',
            'endDate',
            'revenueDates',
            'revenueValues',
            'topUsers',
            'topProducts',
            'totalProductsSold',
            'totalProducts',
            'totalProductsOnSale',
            'totalOrders'
        ));
    }
}
