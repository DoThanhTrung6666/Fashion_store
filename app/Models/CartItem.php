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
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class); // Giả sử bạn có model ProductVariant
    }
}
