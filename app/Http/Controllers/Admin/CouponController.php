<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Coupon\ApplyCouponRequest;
use App\Http\Requests\Coupon\CreateCouponRequest;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CouponController extends Controller
{
    public function index(){
        $coupons = Coupon::orderBy('id','desc')->get();
        return Inertia::render('Admin/Coupon/Index',[
            'coupons' => $coupons,
        ]);
    }

    public function create(){
        return Inertia::render('Admin/Coupon/Create');
    }
    public function store(CreateCouponRequest $request){
        // dd($request->validated());
        Coupon::create($request->validated());
        return to_route('admin.coupons')->with('success','Đã tạo!');
    }

    public function delete(Coupon $coupon){
        // dd($coupon);
        $coupon->delete();
        return back()->with('success','Đã xóa!');
    }

    
}
