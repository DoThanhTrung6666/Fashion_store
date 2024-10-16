<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
    ];
    public static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $category->description = Str::slug($category->name);
        });
    }
    public function productHome(){
        return $this->hasMany(Product::class);
    }
}
