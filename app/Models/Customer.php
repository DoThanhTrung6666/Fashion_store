<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', // Thêm user_id vào đây
        'status',
    ];
    public function cartItems()
    {
        return $this->hasMany(CartItem::class); // Giả sử bạn có model CartItem
    }
}
