<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'payment',
        'order_date',
        'status',
        'total_amount',
        'user_id', // Thêm dòng này
    ];
}
