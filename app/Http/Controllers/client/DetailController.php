<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    //
    public function show($id){
        // tìm sản phẩm theo id
        $detail = Product::with('variants')->findOrFail($id);
        return view('client.productDetail',compact('detail'));
    }
}
