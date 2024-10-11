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
        $product->loadCount(['reviews as average_rating' => function($query) {
            $query->select(DB::raw('coalesce(avg(rating), 0)')); 
        }]);
        $recommendProducts = Product::where('category_id', $product->category_id)
                            ->where('id', '!=', $product->id)
                            ->take(4) 
                            ->withCount(['reviews as average_rating' => function($query) {
                                $query->select(DB::raw('coalesce(avg(rating), 0)')); 
                            }])
                            ->get();
        $recentReviews = $product->reviews()
        ->latest()
        ->take(3) 
        ->with('user') 
        ->get();
        return Inertia::render('Customer/FoodDetail/Index', [
            'product' => $product,
            'recommendProducts' => $recommendProducts,
            'reviews' => $recentReviews,
        ]);
    }

    
    public function getFoodByCategory(Category $category)
    {
        $category->load(['products' => function($query) {
            $query->withCount(['reviews as average_rating' => function($query) {
                $query->select(DB::raw('coalesce(avg(rating), 0)'));
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
