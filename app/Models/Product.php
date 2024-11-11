<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'image', 'description', 'price', 'discount', 'stock_quantity', 'brand_id', 'category_id', 'status'];

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function categoryHome()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
