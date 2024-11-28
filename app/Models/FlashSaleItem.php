<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashSaleItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'flash_sale_id',
        'product_id',
        'price',
    ];

    public function flashSale()
    {
        return $this->belongsTo(FlashSale::class); // FlashSaleItem thuộc về một FlashSale
    }
    public function product()
    {
        return $this->belongsTo(Product::class); // Giả sử khóa ngoại trong bảng FlashSaleItem là product_id
    }
}
