<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\AdminUpdateOrderRequest;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminOrderController extends Controller
{
    // public function index(Request $request){
    //     $orders = Order::when($request->search,function($query) use($request){
    //         $query->where('order_code','like','%'.$request->search.'%')->orWhereHas('customer',function($q) use($request){
    //             $q->where('name', 'like', '%' . $request->search . '%');
    //         });
    //     })->with('customer')->paginate(10)->withQueryString();
    //     return Inertia::render('Admin/Order/Index',[
    //         'orders' => $orders,
    //         'searchTerm' => $request->search
    //     ]);
    // }
    public function index(Request $request)
    {
        $orders = Order::when($request->search, function($query) use($request) {
            // Tìm kiếm theo mã đơn hàng hoặc tên khách hàng
            $query->where('order_code', 'like', '%' . $request->search . '%')
                ->orWhereHas('customer', function($q) use($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                });
        })
        ->when($request->status, function($query) use($request) {
            // Lọc theo trạng thái nếu có yêu cầu
            $query->where('status', $request->status);
        })
        ->with('customer')
        ->paginate(10)
        ->withQueryString();

        return Inertia::render('Admin/Order/Index', [
            'orders' => $orders,
            'searchTerm' => $request->search,
            'statusTerm' => $request->status, 
        ]);
    }


    public function show(Order $order){
        // $orderDetail = $order->with('orderItems')->get();
        $order->load(['orderItems.product','customer']);
        $staffs = User::where('role_id',3)->get();
        // dd($order);
        return Inertia::render('Admin/Order/OrderDetail',[
            'orders' => $order,
            'staffs' => $staffs
        ]);
    }

    public function update(AdminUpdateOrderRequest $request, Order $order){
        // dd($request->validated());
        // dd($order);
        $order->update($request->validated());
        return to_route('admin.orders')->with('success','Đã cập nhật đơn hàng');

    }
}
