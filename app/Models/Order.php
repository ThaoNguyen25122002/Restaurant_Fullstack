<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'order_code',
        'staff_id',
        'total_amount',
        'original_total_amount',
        'payment_method',
        'status',
        'delivery_address',
        'note',
    ];

    public function customer(){
        return $this->belongsTo(User::class,'customer_id');
    }
    public function staff(){
        return $this->belongsTo(User::class,'staff_id');
    }

    public function orderItems(){
        return $this->hasMany(OrderItem::class,'order_id');
    }
}
