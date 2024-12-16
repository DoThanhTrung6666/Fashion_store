<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'color_id', 'size_id','stock_quantity','image_variant'];

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

        // Các thuộc tính và phương thức khác

        public function orderItems()
        {
            return $this->hasMany(OrderItem::class, 'product_variant_id');
        }
        public function comments()
{
    return $this->hasMany(Comment::class, 'product_variant_id', 'id');
}

}
