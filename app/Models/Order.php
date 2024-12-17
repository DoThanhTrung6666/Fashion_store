<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'payment',
        'order_date',
        'status',
        'total_amount',
        'name_order',
        'phone_order',
        'address_order',
        'content_order'
    ];


    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function orderItems()
{
    return $this->hasMany(OrderItem::class, 'order_id', 'id');
}
// app/Models/Order.php

public function products()
{
    return $this->hasMany(Product::class); // Một đơn hàng có nhiều sản phẩm
}

public function comments()
{
    return $this->hasMany(Comment::class, 'order_id'); // Liên kết với comment qua 'order_id'
}

}
