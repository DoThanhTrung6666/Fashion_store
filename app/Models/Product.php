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

public function order()
{
    return $this->belongsTo(Order::class); // Mỗi sản phẩm thuộc về một đơn hàng
}

public function getAverageRatingAttribute()
{
    return $this->comments()->avg('rating'); // Tính trung bình rating của các bình luận
}


}
