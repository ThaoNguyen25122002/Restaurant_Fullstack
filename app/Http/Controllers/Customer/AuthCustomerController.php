<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Jobs\SendMailResetJob;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
class AuthCustomerController extends Controller
{
    public function login(LoginRequest $request)  {
        $fields = $request->validated();
        if(Auth::attempt($fields,$request->remember)){
            $request->session()->regenerate();
            return to_route('home');
        }
        return back()->withErrors(['email' => 'Email hoặc mật khẩu không đúng.'])->onlyInput('email');
    }
    public function register(RegisterRequest $request)  {
        $fields = $request->validated();
        $fields['role_id'] = 2;
        $user = User::create($fields);
        Auth::login($user);
        return to_route('home');
    }


    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }


    public function sendResetLinkEmail(Request $request){
        $messages = [
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.exists' => 'Địa chỉ email này không tồn tại trong hệ thống.',
        ];
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], $messages);
        $token = Str::random(60);
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => Hash::make($token),
                'created_at' => now(),
            ]
        );
        $resetUrl = url("/reset-password?token=$token&email={$request->email}");
        // Mail::to($request->email)->send(new ResetPasswordMail($resetUrl));
        SendMailResetJob::dispatch($resetUrl, $request->email);
        return back()->with('success','Vui lòng kiểm tra email của bạn.');
    }

    public function resetPassword(Request $request)
    {
        $messages = [
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.exists' => 'Địa chỉ email này không tồn tại trong hệ thống.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
            'password.confirmed' => 'Mật khẩu không khớp.',
        ];
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed|min:6',
        ],$messages);

        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();      
       
        if (! $resetRecord || ! Hash::check($request->token, $resetRecord->token)) {
            return back()->withErrors('Mã thông báo hoặc email không hợp lệ!');
        }
        $user = User::where('email', $request->email)->first();
        $user->update(['password' => Hash::make($request->password)]);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return to_route('login')->with('success','Cập nhật mật khẩu thành công.');
    }
}
