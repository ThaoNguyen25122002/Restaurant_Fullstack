<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index(Request $request){
        $categories = Category::when($request->search, function($query) use($request){
            $query->where('category_name','like','%'.$request->search.'%');
        })->withCount('products')->paginate(5)->withQueryString();
        // dd($categories);
        // dd($categories);
        // dd($categories);
        return Inertia('Admin/Category/Index',[
            "categories" => $categories,
            'searchTerm' => $request->search,
            'categoryTerm' => $request->category
        ]);
    }

    public function store(CreateCategoryRequest $request, Category $category){
        // dd($request->all());
        $fields = $request->except('category_image','newImage');
        if($request->hasFile('category_image')){
            $file = $request->category_image;
            $path = $file->store('categories',['disk'=>'public']);
            $fields['category_image'] = $path;
        }
        $category->create($fields);
        return to_route('admin.categories')->with('success','Đã tạo danh mục.');
    }

    public function update(UpdateCategoryRequest $request, Category $category){
        // dd($request->all());
        $fields = $request->except('newImage','category_image');
        if($request->hasFile('newImage')){
            $file = $request->file('newImage');
            $path = $file->store('categories',['disk'=>'public']);
            $fields['category_image'] = $path;
            if($category->category_image){
                Storage::disk('public')->delete($category->category_image);
            }
        }
        $category->update($fields);
        return to_route('admin.categories')->with('success','Cập nhật thành công.');
        
    }
}
