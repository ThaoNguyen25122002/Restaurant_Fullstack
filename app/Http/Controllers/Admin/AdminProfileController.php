<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends Controller
{
    public function updateProfile(UpdateUserRequest $request, User $user){
        // dd($user);
        $fields = $request->except('password');
        if(!empty($request->password)){
            // dd('not empty');
            $fields['password'] = Hash::make($request->password);
        }
        $user->update($fields);
        return back()->with('success','Profile đã được cập nhật.');
        // dd(' empty');
    }
}
