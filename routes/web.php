<?php

use App\Http\Controllers\Admin\AuthAdminController;
use App\Http\Controllers\Admin\ProductController;
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
        Route::get('products',[ProductController::class,'index'])->name('admin.products');
        Route::get('/products/create',[ProductController::class,'create'])->name('admin.products.create');
        Route::post('products/create',[ProductController::class,'store'])->name('admin.products.store'); 
        Route::get('products/{product}/edit',[ProductController::class,'edit'])->name('admin.products.edit'); 
        Route::put('products/{product}/update',[ProductController::class,'update'])->name('admin.products.update'); 
        Route::delete('products/{product}/delete',[ProductController::class,'delete'])->name('admin.products.delete');
        // ================== Categories ==================// 
        // Route::get('products',[ProductController::class,'index'])->name('admin.categories');
    });
});
