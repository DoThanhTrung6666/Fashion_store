<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'discount_percentage'];

    // Quan hệ với bảng flash_sales
    public function flashSales()
    {
        return $this->hasMany(FlashSale::class);
    }
}
