<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_variant_id', // Giả sử bạn có trường này
        'quantity',   // Giả sử bạn có trường này
        'price',      // Giả sử bạn có trường này
        'order_id',   // Thêm dòng này
    ];
}
