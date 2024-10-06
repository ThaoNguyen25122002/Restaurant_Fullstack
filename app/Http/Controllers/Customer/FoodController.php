<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class FoodController extends Controller
{
    public function index(){

    }


    // public function show(Product $product){
    //     // dd($product);
    //     $recommendProducts = Product::where('category_id',$product->category_id)
    //     ->where('id', '!=', $product->id)->take(4)->get();
    //     return Inertia::render('Customer/FoodDetail/Index',[
    //         'product'=>$product,
    //         'recommendProducts'=>$recommendProducts,
    //     ]);
    // }
    public function show(Product $product)
    {
        // Tính trung bình đánh giá cho sản phẩm đang xem
        $product->loadCount(['reviews as average_rating' => function($query) {
            $query->select(DB::raw('coalesce(avg(rating), 0)')); // Tính trung bình đánh giá
        }]);
        // Lấy các sản phẩm gợi ý cùng danh mục (loại trừ sản phẩm hiện tại)
        $recommendProducts = Product::where('category_id', $product->category_id)
                            ->where('id', '!=', $product->id)
                            ->take(4) // Lấy trước 4 sản phẩm
                            ->withCount(['reviews as average_rating' => function($query) {
                                $query->select(DB::raw('coalesce(avg(rating), 0)')); // Tính trung bình đánh giá
                            }])
                            ->get();
            // Lấy 3 review mới nhất của sản phẩm
        $recentReviews = $product->reviews()
        ->latest() // Sắp xếp theo thời gian mới nhất
        ->take(3)  // Lấy 3 review
        ->with('user') // Giả sử mỗi review có quan hệ với người dùng (user)
        ->get();
        // Trả về dữ liệu cho Vue component
        return Inertia::render('Customer/FoodDetail/Index', [
            'product' => $product,
            'recommendProducts' => $recommendProducts,
            'reviews' => $recentReviews,
        ]);
    }

    // public function getFoodByCategory(Category $category)
    // {
    //     // Sử dụng Eager Loading và lấy luôn cả category đã truyền vào
    //     $category->load('products');
    //     return Inertia::render('Customer/Filter/FoodByCategory',[
    //         'category_name' => $category->category_name,
    //         'products' => $category->products
    //     ]);
    // }
    public function getFoodByCategory(Category $category)
    {
        // Sử dụng Eager Loading để lấy danh sách sản phẩm cùng với trung bình đánh giá
        $category->load(['products' => function($query) {
            $query->withCount(['reviews as average_rating' => function($query) {
                $query->select(DB::raw('coalesce(avg(rating), 0)')); // Tính trung bình đánh giá
            }]);
        }]);

        return Inertia::render('Customer/Filter/FoodByCategory', [
            'category_name' => $category->category_name,
            'products' => $category->products
        ]);
    }

    // public function getAllFood(){
    //     $categories = Category::with('products')->get();
    //     dd($categories);
    // }

   
}
