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
        $endDateTime = date('Y-m-d 23:59:59', strtotime($endDate));

        // Doanh thu trong ngày
        $todayRevenue = Order::whereDate('order_date', today())
            ->sum('total_amount');

        // Doanh thu theo tháng 
        $currentMonthRevenue = Order::whereYear('order_date', now()->year)
            ->whereMonth('order_date', now()->month)
            ->sum('total_amount');

        $formattedCurrentMonthRevenue = number_format($currentMonthRevenue, 0, ',', '.') . ' đ';

        // Tổng đơn hàng trong tuần
        $weeklyOrders = Order::whereBetween('order_date', [
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

        // Lấy danh sách sản phẩm và tổng tồn kho từ các biến thể
        $products = Product::with(['variants' => function ($query) {
            $query->select('product_id', DB::raw('SUM(stock_quantity) as total_stock'))
                ->groupBy('product_id');
        }])->get();

        $orderStatuses = Order::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->get();

        $statusLabels = $orderStatuses->pluck('status');
        $statusCounts = $orderStatuses->pluck('total');

        if ($startDate === $endDate) {
            $revenueData = Order::selectRaw('DATE(order_date) as date, SUM(total_amount) as revenue')
                ->whereDate('order_date', $startDate)
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            $topUsers = Order::select('user_id', DB::raw('COUNT(*) as order_count'))
                ->whereDate('order_date', $startDate)
                ->groupBy('user_id')
                ->orderByDesc('order_count')
                ->take(5)
                ->with(['user:id,name'])
                ->get();

            $topProducts = OrderItem::select(
                    'products.id as product_id', 
                    'products.name as product_name', 
                    DB::raw('SUM(order_items.quantity) as total_sold')
                )
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->join('product_variants', 'order_items.product_variant_id', '=', 'product_variants.id')
                ->join('products', 'product_variants.product_id', '=', 'products.id')
                ->whereDate('orders.order_date', $startDate)
                ->groupBy('products.id', 'products.name')
                ->orderByDesc('total_sold')
                ->take(5)
                ->get();
        } else {
            $revenueData = Order::selectRaw('DATE(order_date) as date, SUM(total_amount) as revenue')
                ->whereBetween('order_date', [$startDate.' 00:00:00', $endDateTime])
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            $topUsers = Order::select('user_id', DB::raw('COUNT(*) as order_count'))
                ->whereBetween('order_date', [$startDate.' 00:00:00', $endDateTime])
                ->groupBy('user_id')
                ->orderByDesc('order_count')
                ->take(5)
                ->with(['user:id,name'])
                ->get();

            $topProducts = OrderItem::select(
                    'products.id as product_id', 
                    'products.name as product_name', 
                    DB::raw('SUM(order_items.quantity) as total_sold')
                )
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->join('product_variants', 'order_items.product_variant_id', '=', 'product_variants.id')
                ->join('products', 'product_variants.product_id', '=', 'products.id')
                ->whereBetween('orders.order_date', [$startDate.' 00:00:00', $endDateTime])
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
            'totalOrders',
            'products',
            'statusLabels',
            'statusCounts'
        ));
    }
}
