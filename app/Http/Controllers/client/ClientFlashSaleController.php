<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use Illuminate\Http\Request;

class ClientFlashSaleController extends Controller
{
    //
    public function index(){
        $flashSales = FlashSale::with('productVariant','sale')
        ->where('status','active')
        ->where('start_time' , '<=' , now())
        ->where('end_time' , '>=' , now())
        ->get();

        return view('client.index',compact('flashSales'));
    }
}
