<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Str;




class HomeController extends Controller
{
    //
    public function getProductHome()
    {
        // load sản phẩm theo danh mục
        $categories = Category::with('productHome')->get();
        //load sản phẩm all
        $allProducts = Product::with(['variants'])
        ->where('status', 1)
        ->orderBy('created_at', 'DESC')
        ->get();
        //load sản phẩm thịnh hành
        $trendingProducts = Product::with('variants')
            ->where('status', 1)
            ->orderBy('views', 'desc') // sắp xếp theo lượt xem
            ->paginate(8); // phân trang

        //flashsale
        $flashSales = FlashSale::with('sale', 'product')
            ->where('status', 'active')
            ->where('start_time', '<=', Carbon::now()->addMonths())
            ->where('end_time', '>=', now())
            ->get();
        // Lấy tất cả các sản phẩm Flash Sale hiện tại
        $flashSaleItems = FlashSaleItem::whereIn('flash_sale_id', $flashSales->pluck('id'))->get();
        // dd($flashSaleItems);
        $topBanner = Banner::where('position', 1)->where('is_active', 1)->first();  
$bottomBanner = Banner::where('position', 2)->where('is_active', 1)->first();
        $sliderBanners = Banner::where('position', 3)->where('is_active', 1)->get();
        return view('client.index', compact('flashSales', 'categories', 'allProducts', 'trendingProducts','sliderBanners','bottomBanner','topBanner'));
    }
}
