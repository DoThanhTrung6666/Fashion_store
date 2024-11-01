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
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // public function getPaymentStatusAttribute()
    // {
    //     return $this->status === 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán';
    // }
}
