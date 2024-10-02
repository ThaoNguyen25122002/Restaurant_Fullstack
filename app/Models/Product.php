<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'product_name',
        'description',
        'price',    
        'image_url',    
        'slug' ,   
        'quantity',
        'sold_quantity',  
        'set_quantity'    
    ];


    public function category(){
        return $this->belongsTo(Category::class);
    }
    // public static function boot()
    // {
    //     parent::boot();
    //     // Tự động tạo slug khi tạo mới hoặc cập nhật
    //     static::saving(function ($product) {
    //         if (empty($product->slug)) {
    //             $product->slug = Str::slug($product->product_name);
    //         }
    //     });
    // }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->slug = Str::slug($product->product_name);
        });

        static::updating(function ($product) {
            if ($product->isDirty('product_name')) {
                $product->slug = Str::slug($product->product_name);
            }
        });
    }
}
