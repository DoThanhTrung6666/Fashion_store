<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Size;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $products = Product::with('variants')->get();
        return view('admin.product.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $colors = Color::all();
        $sizes = Size::all();
        $categorys = Category::all();
        $brands = Brand::all();
        return view('admin.product.create',compact('colors','sizes','categorys','brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $validated = $request->validate([
        //     'name' => 'required|string|max:255',
        //     'description' => 'nullable|string',
        //     'price' => 'required|numeric|min:0',
        //     'discount' => 'nullable|numeric|min:0|max:100', // Discount có thể là phần trăm giảm giá (từ 0 đến 100)
        //     'stock_quantity' => 'required|integer|min:0',
        //     'brand_id' => 'required|exists:brands,id', // Kiểm tra xem brand_id có tồn tại trong bảng brands không
        //     'category_id' => 'required|exists:categories,id', // Kiểm tra category_id có tồn tại trong bảng categories không
        //     'status' => 'required|in:active,inactive', // Kiểm tra status phải là 'active' hoặc 'inactive'
        //     'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Kiểm tra file image (nếu có)
        //     'variant.*.color_id' => 'required|exists:colors,id', // Kiểm tra color_id có tồn tại
        //     'variant.*.size_id' => 'required|exists:sizes,id', // Kiểm tra size_id có tồn tại
        //     'variant.*.price' => 'required|numeric|min:0',
        //     'variant.*.stock_quantity' => 'required|integer|min:0',
        // ]);
        //
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/product', 'public'); // Lưu ảnh vào storage/app/public/images
        }else{
            // $path = null;
        }
        // $product = Product::create(array_merge(
        //     //array_merge để kết hợp thuộc tính khác và đường dẫn ảnh thành 1 mảng duy nhất
        //     $validated,
        //     ['image' => $path] // Thêm đường dẫn ảnh vào mảng
        // ));
        // cách 2 để thêm sản phẩm
        $product = Product::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'discount' => $request->input('discount'),
            'stock_quantity' => $request->input('stock_quantity'),
            'brand_id' => $request->input('brand_id'),
            'category_id' => $request->input('category_id'),
            'status'=> $request->input('status'),
            'image' => $path, // Lưu đường dẫn ảnh vào cột 'image'
        ]);
        foreach($request->variant as $variant){
            ProductVariant::create([
                'product_id' => $product->id,
                'color_id' => $variant['color_id'],
                'size_id' => $variant['size_id'],
                'price' => $variant['price'],
                'stock_quantity' => $variant['stock_quantity'],
            ]);
        }
        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
