<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthStaffController extends Controller
{
    public function login(LoginRequest $request){
       
        if(Auth::attempt($request->all())){
            $request->session()->regenerate();
            $user = Auth::user();
            // dd($request->all());
            if($user->role->name === 'staff'){
                return to_route('staff.orders');
            }else{
                Auth::logout();
                return back()->withErrors(['email'=>"Bạn không có quyền truy cập nhân viên!"])->onlyInput('email');
            }
        }
        return back()->withErrors(['email'=>"Tài khoản hoặc mật khẩu không đúng!"])->onlyInput('email'); 
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('staff.orders');
    }
}
