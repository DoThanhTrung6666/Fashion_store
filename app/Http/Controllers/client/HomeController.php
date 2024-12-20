<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use App\Models\Product;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;




class HomeController extends Controller
{
    //
    public function getProductHome()
    {

        $vouchers = Voucher::where('status', 2)
            ->paginate(4); // Phân trang 4 items


        // load sản phẩm theo danh mục
        $categories = Category::with('productHome')->get();
        //load sản phẩm all
        $allProducts = Product::with(['variants', 'flashSaleItems.flashSale.sale'])
            ->where('status', 1)
            ->orderBy('created_at', 'DESC')
            ->paginate(8);
        //load sản phẩm thịnh hành
        $trendingProducts = Product::with('variants', 'flashSaleItems.flashSale.sale')
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





        $topBanner = Banner::where('position', 1)->where('is_active', 1)->first();
        $bottomBanner = Banner::where('position', 2)->where('is_active', 1)->first();
        $sliderBanners = Banner::where('position', 3)->where('is_active', 1)->get();
        return view('client.index', compact('flashSales', 'categories', 'allProducts', 'trendingProducts', 'sliderBanners', 'bottomBanner', 'topBanner', 'vouchers'));
    }


    public function getFlashSale()
    {
        $flashSales = FlashSale::with('sale', 'product', 'flashSaleItems.product')
            // ->where('status', 'Đang diễn ra')
            ->where('start_time', '<=', Carbon::now()->addMonths())
            ->where('end_time', '>=', now())
            ->first();
        // $flashSales = FlashSale::with('sale', 'product', 'flashSaleItems.product')
        // ->where(function ($query) {
        //     $query->where('status', 'Đang diễn ra')
        //           ->orWhere('status', 'Sắp diễn ra');
        // })
        // ->where('end_time', '>=', now())
        // ->orderBy('start_time', 'asc') // Ưu tiên cái sắp diễn ra
        // ->first();
        if ($flashSales) {
            // Duyệt qua các sản phẩm trong FlashSaleItems và gán URL hình ảnh
            $flashSales->flashSaleItems->each(function ($item) {
                if ($item->product && $item->product->image) {
                    // xem chi tiết sản phẩm
                    $item->product->link = route('detail.show', $item->product->id);
                    // Cập nhật hình ảnh của sản phẩm với URL đầy đủ
                    $item->product->image = Storage::url($item->product->image);
                    // xem giá product
                    $item->product->price = number_format($item->product->price);
                    // xem giá sale
                    $item->price = number_format($item->price);
                    // xem %giảm giá
                    // $item->flash_sale_id->sale->discount_percentage = number_format($item->flash_sale_id->sale->discount_percentage);

                }
            });
            $flashSales->sale->discount_percentage = number_format($flashSales->sale->discount_percentage);
        }
        return response()->json($flashSales);
    }

    public function getFlashSaleHome()
    {
        $flashSales_sapdienra = FlashSale::with('flashSaleItems')
            ->where('status', 'Sắp diễn ra')
            ->get();
        $flashSales_dangdienra = FlashSale::with('flashSaleItems')
            ->where('status', 'Đang diễn ra')
            ->get();
        return view('client.list-flash-sale', compact('flashSales_dangdienra', 'flashSales_sapdienra'));
    }
}
