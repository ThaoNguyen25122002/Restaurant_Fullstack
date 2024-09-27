<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthAdminController extends Controller
{
    public function login(LoginRequest $request){
       
        if(Auth::attempt($request->all())){
            $request->session()->regenerate();
            $user = Auth::user();
            // dd($request->all());
            if($user->role->name === 'admin'){
                return redirect()->intended(route('admin.dashboard'));
            }else{
                Auth::logout();
                return back()->withErrors(['email'=>"Bạn không có quyền truy cập admin!"])->onlyInput('email');
            }
        }
        return back()->withErrors(['email'=>"Tài khoản hoặc mật khẩu không đúng!"])->onlyInput('email'); 
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
