<?php

use App\Http\Controllers\Admin\AuthAdminController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Admin/Dashboard/Index');
});
Route::prefix('admin')->group(function(){
    Route::middleware('guest')->group(function(){
        Route::inertia('/login','Admin/LoginAdmin/Index')->name('admin.login');
        Route::post('login',[AuthAdminController::class,'login'])->name('admin.login');
    });
    
    Route::middleware('isAdmin')->group(function(){
        Route::get('dashboard', function () {
            return Inertia::render('Admin/Dashboard/Index');
        })->name('admin.dashboard');
        Route::post('admin/logout',[AuthAdminController::class,'logout'])->name('admin.logout');
        // ================== Users ==================//
        Route::get('users',[UserController::class,'index'])->name('admin.users');
        Route::post('users',[UserController::class,'store'])->name('admin.users.store');
        Route::put('users/{user}/update',[UserController::class,'update'])->name('admin.users.update');
        Route::delete('users/{id}/delete',[UserController::class,'delete'])->name('admin.users.delete');
        // ================== Products ==================//
        Route::get('products', function () {
            return Inertia::render('Admin/Product/Index');
        })->name('admin.products');
    });
});
