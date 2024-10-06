<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(){
        $orderCount = Order::where('status','!=','Đã hủy')->count();
        $revenue = Order::whereIn('status', ['Đã giao hàng', 'Đã đánh giá'])->sum('total_amount');
        $dishCount = Product::count();
        $customerCount = User::where('role_id',2)->count();
        $recentOrders = Order::latest()->take(4)->with('customer')->get();
        $revenueData = $this->getRevenueData();
        // dd($revenueData);
        // dd($orderCount,
        // $revenue,
        // $dishCount,
        // $customerCount);
        return Inertia::render('Admin/Dashboard/Index',[
        'orderCount' => $orderCount,
        'revenue' =>  $revenue,
        'dishCount' =>  $dishCount,
        'customerCount' =>  $customerCount,
        'recentOrders' =>  $recentOrders,
        'revenueData' =>  $revenueData,
        ]);
    }
    public function getRevenueData()
    {
        $currentYear = Carbon::now()->year;

        $monthlyRevenue = Order::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total_amount) as total')
        )
        ->whereYear('created_at', $currentYear)
        ->whereIn('status', ['Đã giao hàng', 'Đã đánh giá']) // Lọc theo status nếu cần
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->orderBy('month')
        ->get();
        return $monthlyRevenue;
        // return response()->json($monthlyRevenue);
    }
}
