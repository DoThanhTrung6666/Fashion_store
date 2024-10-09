<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Category;
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
        $allProducts = Product::all();
        //load sản phẩm thịnh hành
        $trendingProducts = Product::with('variants')
        ->orderBy('views','desc') // sắp xếp theo lượt xem
        ->paginate(10);// phân trang
        return view('client.index',compact('categories','allProducts','trendingProducts'));

    }
}
