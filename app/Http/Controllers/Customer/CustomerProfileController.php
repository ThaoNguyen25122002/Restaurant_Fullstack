<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerProfileController extends Controller
{
    public function update(UpdateUserRequest $request, User $user){
        $fields = $request->except('password');
        // dd($fields);
        if(!empty($request->password)){
            // dd('not empty');
            $fields['password'] = Hash::make($request->password);
        }
        $user->update($fields);
        return back()->with('success','Đã cập nhật.');
    }
}
