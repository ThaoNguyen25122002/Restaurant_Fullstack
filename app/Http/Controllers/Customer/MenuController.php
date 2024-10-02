<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MenuController extends Controller
{
    public function index(){
        $categories = Category::with('products')->get();
        return Inertia::render('Customer/Menu/Index',[
            'categories' => $categories
        ]);
    }
}
