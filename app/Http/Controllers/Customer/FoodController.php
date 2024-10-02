<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FoodController extends Controller
{
    public function index(){

    }


    public function show(Product $product){
        // dd($product);
        $recommendProducts = Product::where('category_id',$product->category_id)
        ->where('id', '!=', $product->id)->take(4)->get();
        return Inertia::render('Customer/FoodDetail/Index',[
            'product'=>$product,
            'recommendProducts'=>$recommendProducts,
        ]);
    }

    public function getFoodByCategory(Category $category)
    {
        // Sử dụng Eager Loading và lấy luôn cả category đã truyền vào
        $category->load('products');
        return Inertia::render('Customer/Filter/FoodByCategory',[
            'category_name' => $category->category_name,
            'products' => $category->products
        ]);
    }

    // public function getAllFood(){
    //     $categories = Category::with('products')->get();
    //     dd($categories);
    // }

   
}
