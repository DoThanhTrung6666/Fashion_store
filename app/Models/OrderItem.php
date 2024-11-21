<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_variant_id',
        'quantity',
        'price',
        'order_id',  
    ];

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class,'product_variant_id');
    }

    public function order()
{
    return $this->belongsTo(Order::class,'order_id'); 
}
}


