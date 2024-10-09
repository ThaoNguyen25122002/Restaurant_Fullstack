<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class StatisticalController extends Controller
{
   
    public function index(Request $request)
    {
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
        $tongDonHang = Order::where('status', '!=', 'Đã hủy')
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
            // dd($tongMonAn);
        return Inertia::render('Admin/Statistical/Index', [
            'doanhThu' => $doanhThu ?  $doanhThu : 0,
            'tongMonAn' => $tongMonAn ? $tongMonAn : 0,
            'tongDonHang' => $tongDonHang ? $tongDonHang : 0,
            'tiLeThanhCong' => $tiLeThanhCong ? $tiLeThanhCong : 0,
            'tiLeThatBai' => $tiLeThatBai ? $tiLeThatBai : 0,
            'banChayNhat' => $banChayNhat ? $banChayNhat : null,
            'banItNhat' => $banItNhat ? $banItNhat : null,
        ]);
    }


    public function orderStatistics(Request $request){
        $timeframe = $request->input('timeFrame','today');
        // $users = DB::table('users')->leftJoin('orders','users.id', '=', 'orders.customer_id')->select('users.name', 'orders.total_amount')->get();
        $now = Carbon::now();
        switch($timeframe){
            case 'week':
                $timeframe = (clone $now)->startOfWeek();
                break;
            case 'month':
                $timeframe = (clone $now)->startOfMonth();
                break;
            case 'year':
                $timeframe = (clone $now)->startOfYear();
                break;
            case 'today':
            default:
                $timeframe = (clone $now)->startOfDay();
                break;
        }
        $tongDonHang = Order::whereIn('status',['Đã hủy','Đã giao hàng', 'Đã đánh giá'])->whereBetween('created_at',[$timeframe, $now])->count();
        // $donHangThanhCong = Order::whereIn('status',['Đã giao hàng', 'Đã đánh giá'])->whereBetween('created_at',[$timeframe, $now])->count();
        $donHangThatBai = Order::where('status','Đã hủy')->whereBetween('created_at',[$timeframe, $now])->count();
        $tongDoanhThu = Order::whereIn('status',['Đã giao hàng', 'Đã đánh giá'])->whereBetween('created_at',[$timeframe, $now])->sum('total_amount');
        $donDangXuLy = Order::whereIn('status',['Chờ duyệt', 'Đã nhận đơn', 'Đang giao hàng'])->whereBetween('created_at',[$timeframe, $now])->count();
        $donBiHuy = Order::where('status','Đã hủy')->whereBetween('created_at',[$timeframe, $now])->count();
        
        return Inertia::render('Admin/Statistical/OrderStatistics',[
            'tongDonHang' => $tongDonHang,
            'donHangThatBai' => $donHangThatBai,
            'tongDoanhThu' => $tongDoanhThu,
            'donDangXuLy' => $donDangXuLy,
            'donBiHuy' => $donBiHuy,
        ]);
    }



    public function customerStatistics(){
        // $soLuongDonTheoTungKhachHang = User::join('orders','orders.customer_id','users.id')->select()
        $soLuongKhachHang = User::where('role_id',3)->count();
        $soLuongDonHang = Order::whereIn('status',['Đã giao hàng','Đã đánh giá'])->count();
        $tongDoanhThu =  Order::whereIn('status',['Đã giao hàng','Đã đánh giá'])->sum('total_amount');
        $doanhThuTrungBinhCuaMoiKhachHang = $tongDoanhThu/$soLuongKhachHang;
        $soLuongDonTheoTrungBinhCuaKhachHang = $soLuongDonHang/$soLuongKhachHang;
        $danhSachKhachCoDoanhThuCaoNhat = Order::join('users','orders.customer_id','=','users.id')
                                                ->select('users.name',
                                                DB::raw('SUM(orders.total_amount) as total_revenue'),
                                                DB::raw('COUNT(orders.id) as total_orders'))   
                                                ->groupBy('users.id','users.name')
                                                ->orderByDesc('total_revenue')
                                                ->take(5)
                                                ->get();      
        $newCustomers = User::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(id) as total')
        )
        ->where('role_id',3)
        ->whereYear('created_at', Carbon::now()->year)
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->orderBy('month')
        ->get();
        // dd($newCustomers);                                    
                                                                                                        
        // dd($doanhThuTrungBinhCuaMoiKhachHang);
        return Inertia::render('Admin/Statistical/CustomerStatistics',[
            'soLuongKhachHang' => $soLuongKhachHang,
            'doanhThuTrungBinhCuaMoiKhachHang' => $doanhThuTrungBinhCuaMoiKhachHang,
            'soLuongDonTheoTrungBinhCuaKhachHang' => $soLuongDonTheoTrungBinhCuaKhachHang,
            'danhSachKhachCoDoanhThuCaoNhat' => $danhSachKhachCoDoanhThuCaoNhat,
            'newCustomers' => $newCustomers,
            // 'soLuongKhachHang' => $soLuongKhachHang,
        ]);
    }

    public function categoryStatistics(Request $request){
        $timeframe = $request->input('timeFrame','today');
        $now = Carbon::now();
        switch($timeframe){
            case 'week':
                $timeframe = (clone $now)->startOfWeek();
                break;
            case 'month':
                $timeframe = (clone $now)->startOfMonth();
                break;
            case 'year':
                $timeframe = (clone $now)->startOfYear();
                break;
            case 'today':
            default:
                $timeframe = (clone $now)->startOfDay();
                break;
        }
        // dd($timeframe);
        
        $categoryData = Category::join('products', 'categories.id', '=', 'products.category_id')
        ->join('order_items', 'products.id', '=', 'order_items.product_id')
        ->join('orders', 'order_items.order_id', '=', 'orders.id')
        ->selectRaw('categories.category_name, 
                    SUM(order_items.quantity) as total_sold, 
                    SUM(order_items.price * order_items.quantity) as total_revenue')
        ->whereIn('orders.status', ['Đã giao hàng', 'Đã đánh giá']) 
        ->where('orders.created_at', '>=', $timeframe)
        ->groupBy('categories.id', 'categories.category_name')
        ->orderBy('total_revenue', 'desc') 
        ->get();
        //  bán chạy nhất
        $bestSellingCategory = $categoryData->first();

        //  bán ít nhất
        $leastSellingCategory = $categoryData->last();

        // Tính trung bình doanh thu của tất cả danh mục
        $averageRevenue = $categoryData->avg('total_revenue');
        // dd($categoryData);
        return Inertia::render('Admin/Statistical/CategoryStatistics',[
            'categoryData' => $categoryData,
            'bestSellingCategory' => $bestSellingCategory,
            'leastSellingCategory' => $leastSellingCategory,
            'averageRevenue' => $averageRevenue,
        ]);
    }


    public function foodStatistics(){
        $bestSellingFood = Product::orderBy('sold_quantity', 'desc')->first();
        $leastSellingFood = Product::orderBy('sold_quantity', 'asc')->first();
        $topSelling = Product::orderBy('sold_quantity', 'desc')->take(5)->get();
        $sumQuantity = Product::sum('sold_quantity');
        $topRating = Review::join('products','products.id','=','reviews.product_id')
                        // ->selectRaw('products.product_name','COALESCE(AVG(reviews.rating), 0) as average_rating')
                        ->selectRaw('products.product_name, COALESCE(AVG(reviews.rating), 0) as average_rating, COUNT(reviews.id) as count_rating')
                        ->groupBy('products.id')
                        ->orderBy('average_rating', 'desc')
                        ->limit(1)->first();
        $lowestRating = Review::join('products','products.id','=','reviews.product_id')
        // ->selectRaw('products.product_name','COALESCE(AVG(reviews.rating), 0) as average_rating')
                            ->selectRaw('products.product_name, COALESCE(AVG(reviews.rating), 0) as average_rating, COUNT(reviews.id) as count_rating')
                            ->groupBy('products.id')
                            ->orderBy('average_rating', 'asc')
                            ->limit(1)->first();
        // dd($lowestRating);
        // dd($sumQuantity);
        
        return Inertia::render('Admin/Statistical/FoodStatistics', [
            'bestSellingFood' => $bestSellingFood,
            'leastSellingFood' => $leastSellingFood,
            'topSelling' => $topSelling,
            'sumQuantity' => $sumQuantity,
            'topRating' => $topRating,
            'lowestRating' => $lowestRating,
        ]);
    }

    public function staffStatistics(Request $request){
        $timeframe = $request->input('timeFrame','today');
        // $users = DB::table('users')->leftJoin('orders','users.id', '=', 'orders.customer_id')->select('users.name', 'orders.total_amount')->get();
        $now = Carbon::now();
        switch($timeframe){
            case 'week':
                $timeframe = (clone $now)->startOfWeek();
                break;
            case 'month':
                $timeframe = (clone $now)->startOfMonth();
                break;
            case 'year':
                $timeframe = (clone $now)->startOfYear();
                break;
            case 'today':
            default:
                $timeframe = (clone $now)->startOfDay();
                break;
        }
        $staffStatistics = User::where('role_id', 3)
                                ->leftJoin('orders', 'orders.staff_id', '=', 'users.id')
                                ->whereBetween('orders.created_at', [$timeframe, $now])
                                ->whereIn('orders.status', ['Đã giao hàng', 'Đã đánh giá'])
                                ->selectRaw('users.name, COUNT(orders.id) as count_orders,  COALESCE(SUM(orders.total_amount), 0) as total_revenue')
                                ->groupBy('users.id', 'users.name')
                                ->orderBy('total_revenue', 'desc') 
                                ->get();
        $quantityStaff = User::where('role_id', 3)->count();
        $quantityOrders = Order::whereIn('status',['Đã hủy','Đã giao hàng', 'Đã đánh giá'])->whereBetween('created_at',[$timeframe, $now])->count();
        // dd($quantityOrders);
        return Inertia::render('Admin/Statistical/StaffStatistics', [
           'staffStatistics' => $staffStatistics,
           'quantityStaff' => $quantityStaff,
           'quantityOrders' => $quantityOrders,
        //    'staffStatistics' => $staffStatistics,
        ]);
    }

}
