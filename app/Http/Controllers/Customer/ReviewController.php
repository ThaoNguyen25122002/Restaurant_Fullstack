<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(ReviewRequest $request, Order $order){
        // dd($request->all());
        $userId = Auth::id();
        $order->status = 'Đã đánh giá';
        foreach($request->productIds as $product_id){
            Review::create([
                'customer_id' => $userId,
                'product_id' => $product_id,
                'rating' => $request->rating,
                'review' => $request->review,
            ]);
        }
        $order->save();
        return back()->with('success','Đã đánh giá!');
    }
}
