<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\FlashSale;
use App\Models\Product;
use Illuminate\Http\Request;

use Illuminate\Support\Str;




class HomeController extends Controller
{
    //
    public function getProductHome(){
        // load sản phẩm theo danh mục
        $categories = Category::with('productHome')->get();
        //load sản phẩm all
        $allProducts = Product::with(['variants'])->get();
        //load sản phẩm thịnh hành
        $trendingProducts = Product::with('variants')
        ->orderBy('views','desc') // sắp xếp theo lượt xem
        ->paginate(8);// phân trang

        //flashsale
        $flashSales = FlashSale::with('productVariant','sale')
        ->where('status','active')
        ->where('start_time' , '<=' , now())
        ->where('end_time' , '>=' , now())
        ->get()
        ->unique(function ($flashSale) {
            return $flashSale->productVariant->product->id; // Lọc các sản phẩm trùng lặp dựa trên productId
        });
        $flashSales = $flashSales->map(function ($flashSale) {
            return [
                'flashSale' => $flashSale,
                'flashSaleId' => $flashSale->productVariant->product->id,
                'productImage' => $flashSale->productVariant->product->image,
                'productName' => $flashSale->productVariant->product->name, // Tên sản phẩm chính
                'productPrice' => $flashSale->productVariant->product->price,
                'saleName' => $flashSale->sale->name, // Tên chương trình giảm giá
                'salePercentage' => $flashSale->sale->discount_percentage, // Phần trăm giảm giá
                'end_time'=> $flashSale->end_time,
            ];
        });
        return view('client.index',compact('flashSales','categories','allProducts','trendingProducts'));

    }
}
