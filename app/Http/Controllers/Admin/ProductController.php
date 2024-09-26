<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProductController extends Controller
{
    // public function index(Request $request){
    //     // $products = Product::with('category')->get();
    //     $products = Product::when($request->search,function($query) use($request){
    //         $query->where('product_name','like',"%".$request->search."%")->orWhere('description','like',"%".$request->search."%")
    //         ->orWhere('price','like',"%".$request->search."%");
    //     })->with('category')->paginate(5)->withQueryString();
    //     $categories = Category::all();
    //     // dd($products);
    //     // dd($url);
    //     // dd(ProductResource::collection($products));
    //     return Inertia('Admin/Product/Index',[
    //         // 'products' => ProductResource::collection($products),
    //         'products' => $products,
    //         'searchTerm'=>$request->search,
    //         'categories' => $categories,
    //     ]);
    // }
    public function index(Request $request){
        // $products = Product::with('category')->get();
        $categorySlug = $request->category;

        $category = Category::where('slug', $categorySlug)->first();
        $products = Product::when($request->search,function($query) use($request){
            $query->where('product_name','like',"%".$request->search."%")->orWhere('description','like',"%".$request->search."%")
            ->orWhere('price','like',"%".$request->search."%");
        })->when($category, function ($query) use ($category) {
            $query->where('category_id', $category->id);
        })->with('category')->paginate(5)->withQueryString();
        $categories = Category::all();
        // dd(ProductResource::collection($products));
        return Inertia('Admin/Product/Index',[
            // 'products' => ProductResource::collection($products),
            'products' => $products,
            'searchTerm'=>$request->search,
            'categoryTerm'=>$categorySlug,
            'categories' => $categories,
        ]);
    }
    // public function filterCategoryProducts(Request $request){
    //     $products = Product
    // }
    public function edit(Product $product){
        // dd($product);
        $categories = Category::all();
        // dd(new ProductResource($product));
        return inertia('Admin/Product/EditProduct',[
            'categories' => $categories,
            'product' => $product,
        ]);
    }
    public function create(){
        $categories = Category::all();
        // dd(new ProductResource($product));
        return inertia('Admin/Product/CreateProduct',[
            'categories' => $categories,
        ]);
    }

    public function update(ProductUpdateRequest $request,Product $product){
        // dd(123);
        $fields = $request->except('image_url','newImage','_method');
        if($request->hasFile('newImage')){
            // dd('has file');
            $file = $request->file('newImage');
            $filename = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $path = Storage::disk('public')->putFileAs('products',$file,$filename);
            $fields['image_url'] = $path;
            if($product->image_url){
                Storage::disk('public')->delete($product->image_url);
            }
        }
        $product->update($fields);
        return to_route('admin.products')->with('success','Cập nhật thành công!');
    }
    
    public function store(ProductCreateRequest $request,Product $product){
        $fields = $request->validated();
        if($request->hasFile('image_url')){
            $file = $request->image_url;
            $filename = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $path = Storage::disk('public')->putFileAs('products', $file, $filename);
            $fields['image_url'] = $path;
        }
        $product->create($fields);
        return to_route('admin.products')->with('success','Tạo sản phẩm thành công.');
        // $product->create($request->)
    }

    public function delete(Product $product){
        if($product->image_url){
            Storage::disk('public')->delete($product->image_url);
        }
        $product->delete();
        return back()->with('success','Xóa thành công.');
    }
    
}
