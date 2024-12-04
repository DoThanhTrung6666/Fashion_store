<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashSale extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'sale_id', 'start_time', 'end_time', 'status'];

    // Quan hệ với bảng Sale
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    // Quan hệ với bảng ProductVariant
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function flashSaleItems()
    {
        return $this->hasMany(FlashSaleItem::class); // Điều này cho biết mỗi FlashSale có nhiều FlashSaleItem
    }

}
