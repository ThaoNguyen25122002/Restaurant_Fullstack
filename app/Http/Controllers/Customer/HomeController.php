<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $categories = Category::where('is_show',true)->orderBy('sort','desc')->take(8)->get();
        $products = Product::orderBy('id','desc')->take(8)->get();
        // dd($products);
        return inertia('Customer/Home/Index',[
            'products' => $products,
            'categories' => $categories,
        ]);
    }
    public function test(){
        dd(123);
    }
}
