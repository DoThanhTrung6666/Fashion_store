<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    //Hiển thị giỏ hàng
    public function index(){
        

    }
    public function add(Request $request)
    {

    }

    // Xoá sản phẩm khỏi giỏ
    public function remove($id)
    {

    }

    // Thanh toán giỏ hàng
    public function checkout()
    {

    }
}


