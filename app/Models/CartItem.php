<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'cart_id', // Thêm user_id vào đây
        'product_variant_id',
        'quantity',
        // Các thuộc tính khác của giỏ hàng
    ];
}
