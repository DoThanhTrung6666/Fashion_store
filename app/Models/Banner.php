<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
'description',
'image_path',
'link',
'position',
'start_date',
'end_date',
'is_active'   
    ];
}
