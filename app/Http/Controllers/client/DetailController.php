<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use App\Models\Product;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    //

    public function show($id){
        // tìm sản phẩm theo id
        $detail = Product::with('variants','category')->findOrFail($id);
        $variants = $detail->variants;
        $flashSale = FlashSale::where('product_id',$detail->id)
        ->where('start_time','<=',now())
        ->where('end_time' , '>=' ,now())
        ->first();

        // sản phẩm cùng loại
        $relatedProducts = Product::with('variants', 'category')
            ->where('category_id', $detail->category_id)  // Lọc theo category_id của sản phẩm hiện tại
            ->where('id', '!=', $detail->id)  // Loại bỏ sản phẩm hiện tại khỏi danh sách
            ->take(4)  // Lấy tối đa 4 sản phẩm cùng loại
            ->get();

        // dd($detail->toArray());
        return view('client.productDetail',compact('relatedProducts','variants','flashSale','detail'));
    }
}
