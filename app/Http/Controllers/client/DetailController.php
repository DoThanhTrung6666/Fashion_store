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
        $groupByColor = $detail -> variants->groupBy('color.name');
        $groupBySize = $detail -> variants->groupBy('size.name');
        $variants = $detail->variants;
        $flashSale = FlashSale::where('product_variant_id',$detail->variants->first()->id)
        ->where('start_time','<=',now())
        ->where('end_time' , '>=' ,now())
        ->first();

        // dd($detail->toArray());
        return view('client.productDetail',compact('variants','flashSale','detail','groupByColor','groupBySize'));
    }
}
