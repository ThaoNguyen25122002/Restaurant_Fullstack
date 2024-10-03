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
    public function index(){
        $user = Auth::user();
        $orders = Order::where('staff_id',$user->id)
                ->whereIn('status', ['Đã nhận đơn', 'Đang giao hàng'])
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
        return back()->with('success','Đã cập nhật trạng thái đơn hàng.');
    }
}
