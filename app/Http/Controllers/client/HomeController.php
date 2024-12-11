<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            ->where('status', 'Đang diễn ra')
            ->where('start_time', '<=', Carbon::now()->addMonths())
            ->where('end_time', '>=', now())
            ->get();
        // Lấy tất cả các sản phẩm Flash Sale hiện tại
        $flashSaleItems = FlashSaleItem::whereIn('flash_sale_id', $flashSales->pluck('id'))->get();
        // dd($flashSaleItems);
        return view('client.index', compact( 'flashSales','categories', 'allProducts', 'trendingProducts'));
    }

    public function getFlashSale(){
        $flashSales = FlashSale::with('sale', 'product','flashSaleItems.product')
            ->where('status', 'Đang diễn ra')
            ->where('start_time', '<=', Carbon::now()->addMonths())
            ->where('end_time', '>=', now())
            ->first();
            if ($flashSales) {
                // Duyệt qua các sản phẩm trong FlashSaleItems và gán URL hình ảnh
                $flashSales->flashSaleItems->each(function ($item) {
                    if ($item->product && $item->product->image) {
                        // xem chi tiết sản phẩm
                        $item->product->link = route('detail.show', $item->product->id);
                        // Cập nhật hình ảnh của sản phẩm với URL đầy đủ
                        $item->product->image = Storage::url($item->product->image);
                    }
                });
            }
        return response()->json($flashSales);
    }
}
