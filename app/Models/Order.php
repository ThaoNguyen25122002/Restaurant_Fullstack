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
        'payment_method',
        'status',
        'delivery_address',
        'note',
    ];
}
