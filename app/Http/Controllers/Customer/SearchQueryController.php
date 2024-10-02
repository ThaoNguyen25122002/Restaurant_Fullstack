<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchQueryController extends Controller
{
    public function index(Request $request){
        $products = Product::when($request->searchQuery,function($query) use($request){
            $query->where('product_name','like','%'.$request->searchQuery.'%')
            ->orWhere('description','like','%'.$request->searchQuery.'%')
            ->orWhere('price','like','%'.$request->searchQuery.'%');
        })->orderBy('sold_quantity','desc')->get();
        return Inertia::render('Customer/Filter/FoodBySearch',[
            'products' => $products,
            'searchTerm' => $request->searchQuery
        ]);
    }
}
