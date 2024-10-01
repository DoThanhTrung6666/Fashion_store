<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    // tránh tấn công mã hoá bảng
    // dùng để query
    protected $fillable = [];
}
