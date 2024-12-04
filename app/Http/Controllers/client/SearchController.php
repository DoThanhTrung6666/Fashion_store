<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use GuzzleHttp\Psr7\Query;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    //
    public function search(Request $request){
        $keyword = $request->input('keyword','');
        $products = Product::query()
            ->where('name','LIKE',"%{$keyword}%")
            ->paginate(10); // phan trang
        return view('client.search',compact('products','keyword'));
    }
}
