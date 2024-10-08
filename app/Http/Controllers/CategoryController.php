<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

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
            'name' => 'required|string|max:255', // Xác thực trường name
            'description' => 'nullable|string',  // Xác thực trường description
        ]);
        
        // Laravel sẽ tự động thêm giá trị cho `created_at` và `updated_at`, nên không cần validate chúng.
        
        Category::query()->create($data);  // Tạo một bản ghi mới với dữ liệu đã xác thực
        
        return redirect()->route('categories.index');  // Redirect về trang index của categories (nếu route có đúng tên)
        // dd($request->all()); // Debug dữ liệu request nếu cần
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
            'name' => 'required|string|max:255', // Xác thực trường name
            'description' => 'nullable|string', // Xác thực trường description
        ]);
        $category->update($data);
        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {

        // Xóa bản ghi category
        $category->delete();

        return redirect()->route('categories.index');
    }
}
