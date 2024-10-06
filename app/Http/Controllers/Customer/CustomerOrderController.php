<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CustomerOrderController extends Controller
{
    public function index(){
        $orders = Order::where('customer_id',Auth::id())
                        ->where('status', '!=', 'Đã hủy')
                        ->orderByRaw("FIELD(status, 'Đang giao hàng', 'Đã nhận đơn', 'Chờ duyệt', 'Đã giao hàng', 'Đã đánh giá')")
                        ->with('customer','staff','orderItems.product')->get();
        return Inertia::render('Customer/Order/Index',[
            'orders' => $orders
        ]);
    }



    public function delete(Order $order){
        // dd($order->status);
        if($order->status === 'Chờ duyệt'){
            $order->delete();
            return back()->with('success','Đã hủy đơn!');
        }
        return back()->withErrors('Đơn đã được xử lý!');
    }
}
