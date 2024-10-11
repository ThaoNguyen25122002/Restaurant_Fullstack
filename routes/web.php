<?php

use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\AuthAdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\StatisticalController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Customer\AuthCustomerController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\CustomerCouponController;
use App\Http\Controllers\Customer\CustomerOrderController;
use App\Http\Controllers\Customer\CustomerProfileController;
use App\Http\Controllers\Customer\FoodController;
use App\Http\Controllers\Customer\MenuController;
use App\Http\Controllers\Customer\ReviewController;
use App\Http\Controllers\Customer\SearchQueryController;
use App\Http\Controllers\Staff\AuthStaffController;
use App\Http\Controllers\Staff\StaffOrderController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::get('/', function () {
//     return Inertia::render('Admin/Dashboard/Index');
// });
// ================================== Customer ==================================== //
// ================== Home ================ //
Route::get('/',[HomeController::class,'index'])->name('home');
// ================== Handle Cart ================ //
Route::get('/cart',[CartController::class,'index'])->name('cart');
Route::post('/cart/{product}/store',[CartController::class,'store'])->name('cart.store');
// ================== Food Detail ================ //    
Route::get('food/{product:slug}',[FoodController::class,'show'])->name('food.detail');
Route::get('categories/{category:slug}',[FoodController::class,'getFoodByCategory'])->name('foods.category');
// Route::get('foods/menu',[FoodController::class,'test'])->name('foods.menu');
Route::get('menu',[MenuController::class,'index'])->name('foods.menu');
// ================== Search Foods ================ //    
Route::get('foods',[SearchQueryController::class,'index'])->name('foods.search');
// ================== Contact ================ //    
Route::inertia('/contact','Customer/Contact/Index')->name('contact');

// ================== About ================ //    
Route::inertia('/about','Customer/About/Index')->name('about');


// ================================== Customer ==================================== //
Route::middleware('guest')->group(function(){
    Route::inertia('/login','Customer/Auth/Login')->name('login');
    Route::post('/login',[AuthCustomerController::class,'login'])->name('handle.login');
    Route::inertia('/register','Customer/Auth/Register')->name('register');
    Route::post('/register',[AuthCustomerController::class,'register'])->name('handle.register');
    Route::inertia('/reset-link','Customer/Auth/SendResetLinkEmail')->name('sendResetLinkEmail');
    Route::post('/reset-link',[AuthCustomerController::class,'sendResetLinkEmail'])->name('handle.sendResetLinkEmail');
    Route::inertia('/reset-password','Customer/Auth/ResetPassword')->name('resetPassword');
    Route::post('/reset-password',[AuthCustomerController::class,'resetPassword'])->name('handle.resetPassword');

});
Route::middleware('auth')->group(function(){
    Route::post('/logout',[AuthCustomerController::class,'logout'])->name('logout');
    // ================== Handle Checkout ================ //
    Route::get('/checkout',[CheckoutController::class,'index'])->name('checkout');
    Route::post('/payment/cod',[CheckoutController::class,'paymentCod'])->name('payment.cod');
    Route::post('/payment/vnpay',[CheckoutController::class,'payment_vnpay'])->name('payment.vnpay');
    Route::get('/payment/vnpay/return', [CheckoutController::class, 'vnpayReturn'])->name('vnpay.return');
    // ================== Profile ================ //
    Route::inertia('/profile','Customer/Profile/Index')->name('profile');
    Route::put('profile/{user}/update',[CustomerProfileController::class,'update'])->name('profile.update');
    // ================== Orders ================ //
    Route::get('/orders',[CustomerOrderController::class,'index'])->name('orders');
    Route::delete('/orders/{order}/delete',[CustomerOrderController::class,'delete'])->name('orders.delete');
    // ================== Reviews ================ //
    Route::post('/reviews/{order}',[ReviewController::class,'store'])->name('reviews.create');


    // ================== Cart ================ //
    
    Route::patch('/cart/{cartItem}/update',[CartController::class,'update'])->name('cart.update');
    Route::delete('/cart/{cartItem}/delete',[CartController::class,'delete'])->name('cart.delete');
    Route::post('/cart/{orderId}/repurchase',[CartController::class,'repurchase'])->name('cart.repurchase');

    // ================== Apply Coupon ================ //
    Route::post('coupons/apply',[CustomerCouponController::class,'applyCoupon'])->name('customer.coupons.apply');

});

// ================================== Admin ==================================== //
Route::prefix('admin')->group(function(){
    Route::middleware('guest')->group(function(){
        Route::inertia('/login','Admin/LoginAdmin/Index')->name('admin.login');
        Route::post('login',[AuthAdminController::class,'login'])->name('admin.login');
    });
    
    Route::middleware('isAdmin')->group(function(){
        Route::get('dashboard', [DashboardController::class,'index'])->name('admin.dashboard');
        // ================== Admin Profile ==================//
        Route::put('profile/{user}/update',[AdminProfileController::class,'updateProfile'])->name('admin.profile.update');
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
        Route::post('products/set-quantity',[ProductController::class,'setQuantity'])->name('admin.products.setQuantity');
        // Route::get('products',[ProductController::class,'index'])->name('admin.products.filterCategoryProducts');g
        // ================== Categories ==================// 
        Route::get('categories',[CategoryController::class,'index'])->name('admin.categories');
        Route::post('categories/create',[CategoryController::class,'store'])->name('admin.categories.create');
        Route::post('categories/{category}/update',[CategoryController::class,'update'])->name('admin.categories.update');
        Route::delete('categories/{category}/delete',[CategoryController::class,'delete'])->name('admin.categories.delete');
        // ================== Orders ==================// 
        Route::get('orders',[AdminOrderController::class,'index'])->name('admin.orders');
        Route::get('orders/{order}/detail',[AdminOrderController::class,'show'])->name('admin.orders.detail');
        Route::put('orders/{order}/detail',[AdminOrderController::class,'update'])->name('admin.orders.detail.update');
        // ================== Statistical ================ //
        Route::get('statistical',[StatisticalController::class,'index'])->name('admin.statistical');
        Route::get('statistical/orders',[StatisticalController::class,'orderStatistics'])->name('admin.statistical.orders');
        Route::get('statistical/customers',[StatisticalController::class,'customerStatistics'])->name('admin.statistical.customers');
        Route::get('statistical/categories',[StatisticalController::class,'categoryStatistics'])->name('admin.statistical.categories');
        Route::get('statistical/food',[StatisticalController::class,'foodStatistics'])->name('admin.statistical.food');
        Route::get('statistical/staff',[StatisticalController::class,'staffStatistics'])->name('admin.statistical.staff');
        // ================== Coupons ================ //
        Route::get('coupons',[CouponController::class,'index'])->name('admin.coupons');
        Route::get('coupons/create',[CouponController::class,'create'])->name('admin.coupons.create');
        Route::post('coupons/store',[CouponController::class,'store'])->name('admin.coupons.store');
        Route::delete('coupons/{coupon}/delete',[CouponController::class,'delete'])->name('admin.coupons.delete');
    });
});



// ================================== Staff Delivery ==================================== //
Route::prefix('staff')->group(function(){
    Route::middleware('guest')->group(function(){
        Route::inertia('/login','Staff/LoginStaff/Index')->name('staff.login');
        Route::post('login',[AuthStaffController::class,'login'])->name('staff.login');
    });
    
    Route::middleware('isStaff')->group(function(){
        
        Route::get('orders',[StaffOrderController::class,'index'])->name('staff.orders');
        Route::post('staff/logout',[AuthStaffController::class,'logout'])->name('staff.logout');
        Route::put('staff/{user}/update',[StaffOrderController::class,'updateProfile'])->name('staff.profile.update');
        Route::patch('staff/{order}/update',[StaffOrderController::class,'updateStatus'])->name('staff.order.updateStatus');
        // Route::get('orders/detail',[AdminOrderController::class,'show'])->name('admin.orders.detail');
    });
});