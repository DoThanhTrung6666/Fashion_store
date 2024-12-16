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
    public function flashSaleItems()
    {
        return $this->hasMany(FlashSaleItem::class);
    }
    // app/Models/Product.php

// app/Models/Product.php

public function orders()
{
    return $this->belongsToMany(Order::class, 'order_items'); // Thêm bảng trung gian order_items
}


public function getAverageRatingAttribute()
{
    return $this->comments()->avg('rating'); // Tính trung bình rating của các bình luận
}


// danh cho san pham yeu thich 
    public function userFavorites(){
        return $this->belongsToMany(User::class,'favorites');
    }
}
