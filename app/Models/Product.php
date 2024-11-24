<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'image','price', 'description', 'brand_id', 'category_id'];

    public function variants()
    {
        return $this->hasMany(ProductVariant::class,'product_id');
    }
    public function category()
{
    return $this->belongsTo(Category::class);
}

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }
}
