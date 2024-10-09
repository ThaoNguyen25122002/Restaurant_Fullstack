<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request){
        // Lấy giá trị timeframe từ request hoặc mặc định là 'today'
    // $timeframe = $request->input('timeframe','today');
    $timeframe = $request->input('timeFrame','today');
    // dd($timeframe);
    $now = Carbon::now();
    
    // Xử lý logic cho từng khoảng thời gian
    switch ($timeframe) {
        case 'week':
            $startDate = (clone $now)->startOfWeek();
            // dd($startDate);
            break;
        case 'month':
            $startDate = (clone $now)->startOfMonth();
            // dd($startDate);
            break;
        case 'year':
            $startDate = (clone $now)->startOfYear();
            // dd($startDate);
            break;
        case 'today':
        default:
            $startDate = (clone $now)->startOfDay();
            break;
    }
    // dd($startDate, $now);
    // Lấy doanh thu cho khoảng thời gian đã chọn
    $doanhThu = Order::whereBetween('created_at', [$startDate, $now])
    ->whereIn('status', ['Đã giao hàng', 'Đã đánh giá']) 
    ->sum('total_amount');
    // dd($doanhThu);
    // Tổng số món ăn đã bán
    $tongMonAn = OrderItem::whereHas('order', function ($query) use ($startDate, $now) {
        $query->whereBetween('created_at', [$startDate, $now]);
    })->sum('quantity');

    // Tổng số đơn hàng (trừ đơn hàng đã hủy)
    $tongDonHang = Order::whereIn('status', ['Đã hủy','Đã giao hàng', 'Đã đánh giá'])
        ->whereBetween('created_at', [$startDate, $now])
        ->count();

    // Đơn hàng thành công
    $donHangThanhCong = Order::whereIn('status', ['Đã giao hàng', 'Đã đánh giá'])
        ->whereBetween('created_at', [$startDate, $now])
        ->count();

    // Đơn hàng thất bại (đã hủy)
    $donHangThatBai = Order::where('status', 'Đã hủy')
        ->whereBetween('created_at', [$startDate, $now])
        ->count();

    // Tính tỷ lệ thành công và thất bại
    $tiLeThanhCong = $tongDonHang > 0 ? ($donHangThanhCong / $tongDonHang) * 100 : 0;
    $tiLeThatBai = $tongDonHang > 0 ? ($donHangThatBai / $tongDonHang) * 100 : 0;

    // Món bán chạy nhất
    $banChayNhat = OrderItem::select('products.product_name', DB::raw('SUM(order_items.quantity) as total_quantity'))
        ->join('products', 'order_items.product_id', '=', 'products.id')
        ->whereHas('order', function ($query) use ($startDate, $now) {
            $query->whereBetween('orders.created_at', [$startDate, $now]);
        })
        ->groupBy('products.product_name')
        ->orderBy('total_quantity', 'desc')
        ->first();

    // Món bán ít nhất
    $banItNhat = OrderItem::select('products.product_name', DB::raw('SUM(order_items.quantity) as total_quantity'))
        ->join('products', 'order_items.product_id', '=', 'products.id')
        ->whereHas('order', function ($query) use ($startDate, $now) {
            $query->whereBetween('orders.created_at', [$startDate, $now]);
        })
        ->groupBy('products.product_name')
        ->orderBy('total_quantity', 'asc')
        ->first();





        $recentOrders = Order::latest()->take(4)->with('customer')->get();
        $revenueData = $this->getRevenueData();
        // dd($revenueData);
        // dd($orderCount,
        // $revenue,
        // $dishCount,
        // $customerCount);
        return Inertia::render('Admin/Dashboard/Index',[
            // 'doanhThu' => $doanhThu ?  $doanhThu : 0,
            'doanhThu' => $doanhThu ?  $doanhThu : 0,
            'tongMonAn' => $tongMonAn ? $tongMonAn : 0,
            'tongDonHang' => $tongDonHang ? $tongDonHang : 0,
            'tiLeThanhCong' => $tiLeThanhCong ? $tiLeThanhCong : 0,
            'tiLeThatBai' => $tiLeThatBai ? $tiLeThatBai : 0,
            'banChayNhat' => $banChayNhat ? $banChayNhat : null,
            'banItNhat' => $banItNhat ? $banItNhat : null,
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
        ->whereIn('status', ['Đã giao hàng', 'Đã đánh giá']) 
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->orderBy('month')
        ->get();
        return $monthlyRevenue;
    }
}
