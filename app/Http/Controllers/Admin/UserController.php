<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(Request $request){
        // dd($request->search);
        $roles = Role::all();
        // $users = User::with('role')->paginate(10);
        $users = User::when($request->search,function($query) use($request){
            $query->where('name','like','%'.$request->search.'%')->orWhere('email','like','%'.$request->search.'%')
            ->orWhere('phone','like','%'.$request->search.'%');
        })->with('role')->orderBy('id', 'desc')->paginate(5)->withQueryString();
        // dd($users);
        // return Inertia::render('Admin/User/Index');
        return inertia('Admin/User/Index',[
            'roles' => $roles,
            'users' => $users,
            'searchTerm'=>$request->search
        ]);
    }

    public function store(RegisterRequest $request){
        // dd($request->all());
        User::create($request->all());
        return to_route('admin.users')->with(['success'=>'Tạo thành công!']);
    }

    public function delete($id){
        User::findOrFail($id)->delete();
        return back()->with('success','Đã xóa người dùng');
    }


    public function update(UpdateUserRequest $request,User $user){
        // dd($request->all());
        $validatedData = $request->validated();
        $user->update([
            'role_id' => $request->role_id,
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            // Chỉ cập nhật password nếu có
            'password' => $validatedData['password'] ? Hash::make($validatedData['password']) : $user->password,
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'],
        ]);
        // dd($id);
        // User::findOrFail($id)->update();
        return redirect()->route('admin.users')->with('success', 'Cập nhật thành công!');
    }
}
