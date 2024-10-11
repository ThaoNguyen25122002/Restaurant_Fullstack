<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Coupon\ApplyCouponRequest;
use App\Models\Coupon;
use App\Models\UserCoupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerCouponController extends Controller
{
    public function applyCoupon(ApplyCouponRequest $request){
        // dd($request->validated());
        $code = $request->input('code');
        $coupon = Coupon::where('code', $code)
                    ->whereDate('start_date', '<=', now())
                    ->whereDate('end_date', '>=', now())
                    ->whereColumn('used_quantity', '<', 'quantity') 
                    ->first();
        
        // dd($coupon);
        if (!$coupon) {
            return back()->withErrors('Mã đã quá hạn hoặc hết lược sử dụng');
        }
        $alreadyUsed = UserCoupon::where('user_id', Auth::id())
                                    ->where('coupon_id', $coupon->id)
                                    ->exists();
        if ($alreadyUsed) {
            return back()->withErrors('Bạn đã sử dụng mã này!');
        }
        return back()->with('success', $coupon);
    }
}
