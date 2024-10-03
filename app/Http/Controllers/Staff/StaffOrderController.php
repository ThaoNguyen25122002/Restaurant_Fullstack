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
        $orders = Order::where('staff_id',$user->id)->get();
        return Inertia::render('Staff/Order/Index');
    }



    public function updateProfile(UpdateUserRequest $request, User $user){
        // dd($request->all());
        $fields = $request->validated();
        $user->update($fields);
        return back()->with('success','Cập nhật thành công.');
    }
}
