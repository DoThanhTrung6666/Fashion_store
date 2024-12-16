<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'product_variant_id',
        'quantity',
        'price',
    ];

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class,'product_variant_id');
    }

    public function order()
{
    return $this->belongsTo(Order::class,'order_id','id');
}
// app/Models/OrderItem.php

public function product()
{
    return $this->belongsTo(Product::class);  // Mỗi order item thuộc về một sản phẩm
}



}


