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
        'sort',    
        'is_show',    
    ];

    public function products(){
        return $this->hasMany(Product::class,'category_id');
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $category->slug = Str::slug($category->category_name);
        });

        static::updating(function ($category) {
            if ($category->isDirty('category_name')) {
                $category->slug = Str::slug($category->category_name);
            }
        });
    }
}
