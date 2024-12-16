<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_variant_id', // Thay đổi từ 'product_id' thành 'product_variant_id'
        'content',
        'rating',
        'order_id', // Nếu bạn đang lưu thông tin đơn hàng
    ];

    // Quan hệ với model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ với model ProductVariant thay vì Product
    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id'); // Thay đổi tên quan hệ để liên kết với ProductVariant
    }

    // Quan hệ với model Order (nếu có liên kết với order)
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
