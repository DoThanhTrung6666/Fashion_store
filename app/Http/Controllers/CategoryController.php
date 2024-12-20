<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::query()->latest('id')->paginate(10);
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name', 
        ]);
        $data['description'] = Str::slug($data['name']);
        Category::query()->create($data); 

        return redirect()->route('admin.categories.index');  
    }


    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.category.update', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, category $category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $data['description'] = Str::slug($data['name']);
        $category->update($data);
        return redirect()->route('admin.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if($category->productHome()->exists()){
            return back()->with('error', 'Không thể xóa danh mục đang có liên kết với sản phẩm');
        }
        $category->delete();
        return redirect()->route('admin.categories.index');
    }
}
