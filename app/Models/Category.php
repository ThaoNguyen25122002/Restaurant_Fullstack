<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_name',
        'slug',
        'category_image',
        'description',    
    ];

    public static function boot()
    {
        parent::boot();

        // Tự động tạo slug khi tạo mới hoặc cập nhật
        static::saving(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }
}
