<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'discount_percentage',
        'max_discount',
        'min_order_value',
        'start_date',
        'end_date',
        'status'
    ];
}
