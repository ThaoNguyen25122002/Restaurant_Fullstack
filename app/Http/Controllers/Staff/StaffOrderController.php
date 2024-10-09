<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class StaffOrderController extends Controller
{
    public function index(Request $request){
        $status = $request->input('status','Đã nhận đơn');
        $user = Auth::user();
        $orders = Order::where('staff_id',$user->id)
                ->where('status', $status)->latest()
                ->with('customer')->get();

        return Inertia::render('Staff/Order/Index',[
            'orders' => $orders
        ]);
    }



    public function updateProfile(UpdateUserRequest $request, User $user){
        // dd($request->all());
        $fields = $request->validated();
        $user->update($fields);
        return back()->with('success','Cập nhật thành công.');
    }


    public function updateStatus(Request $request, Order $order){
        // dd($request->all());
        $order->update($request->all());
        // if ($order->status === 'Đã nhận đơn' && is_null($order->delivery_start_time)) {
        //     $order->delivery_start_time = now();
        // }
        if ($order->status === 'Đã giao hàng' && is_null($order->delivery_end_time)) {
            $order->delivery_end_time = now();
        }
    
        $order->save();
        return back()->with('success','Đã cập nhật trạng thái đơn hàng.');
    }
}
