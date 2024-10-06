<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class MenuController extends Controller
{
    // public function index(){
    //     $categories = Category::with('products')->get();
    //     return Inertia::render('Customer/Menu/Index',[
    //         'categories' => $categories
    //     ]);
    // }
    public function index()
    {
        // Eager load sản phẩm và tính đánh giá trung bình cho từng sản phẩm
        $categories = Category::with(['products' => function($query) {
            $query->withCount(['reviews as average_rating' => function($query) {
                $query->select(DB::raw('coalesce(avg(rating), 0)')); // Tính trung bình đánh giá
            }]);
        }])->get();
        
        return Inertia::render('Customer/Menu/Index', [
            'categories' => $categories
        ]);
    }
}
