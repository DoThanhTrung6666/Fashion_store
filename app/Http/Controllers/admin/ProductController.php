<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Size;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $products = Product::with('variants','category')->get();
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
        $validated = $request->validate(
            [
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                // 'discount' => 'nullable|numeric|min:0|max:100', // Phần trăm giảm giá từ 0-100
                // 'stock_quantity' => 'required|integer|min:0',
                'brand_id' => 'required|exists:brands,id', // Kiểm tra xem brand_id có tồn tại
                'category_id' => 'required|exists:categories,id', // Kiểm tra category_id có tồn tại
                // 'status' => 'required', // Giá trị chỉ được active hoặc inactive
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Kiểm tra file ảnh
                'variant.*.color_id' => 'required|exists:colors,id', // color_id phải tồn tại trong bảng colors
                'variant.*.size_id' => 'required|exists:sizes,id', // size_id phải tồn tại trong bảng sizes
                // 'variant.*.price' => 'required|numeric|min:0',
                'variant.*.stock_quantity' => 'required|integer|min:0',
                'variant.*.image_variant' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ],
            [
                // Thông báo lỗi cho các trường
                'name.required' => 'Tên sản phẩm là bắt buộc.',
                'name.max' => 'Tên sản phẩm không được dài hơn 255 ký tự.',
                'price.required' => 'Giá sản phẩm là bắt buộc.',
                'price.numeric' => 'Giá sản phẩm phải là số.',
                'price.min' => 'Giá sản phẩm phải lớn hơn hoặc bằng 0.',
                // 'discount.numeric' => 'Phần trăm giảm giá phải là số.',
                // 'discount.min' => 'Phần trăm giảm giá không được nhỏ hơn 0.',
                // 'discount.max' => 'Phần trăm giảm giá không được lớn hơn 100.',
                // 'stock_quantity.required' => 'Số lượng tồn kho là bắt buộc.',
                // 'stock_quantity.integer' => 'Số lượng tồn kho phải là số nguyên.',
                // 'stock_quantity.min' => 'Số lượng tồn kho không được âm.',
                'brand_id.required' => 'Thương hiệu là bắt buộc.',
                'brand_id.exists' => 'Thương hiệu không hợp lệ.',
                'category_id.required' => 'Danh mục là bắt buộc.',
                'category_id.exists' => 'Danh mục không hợp lệ.',
                // 'status.required' => 'Trạng thái là bắt buộc.',
                // 'status.in' => 'Trạng thái chỉ được chọn active hoặc inactive.',
                'image.image' => 'File tải lên phải là một hình ảnh.',
                'image.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif.',
                'image.max' => 'Kích thước ảnh không được vượt quá 2MB.',
                'variant.*.color_id.required' => 'Màu sắc là bắt buộc.',
                'variant.*.color_id.exists' => 'Màu sắc không hợp lệ.',
                'variant.*.size_id.required' => 'Kích thước là bắt buộc.',
                'variant.*.size_id.exists' => 'Kích thước không hợp lệ.',
                // 'variant.*.price.required' => 'Giá biến thể là bắt buộc.',
                // 'variant.*.price.numeric' => 'Giá biến thể phải là số.',
                // 'variant.*.price.min' => 'Giá biến thể phải lớn hơn hoặc bằng 0.',
                'variant.*.stock_quantity.required' => 'Số lượng biến thể là bắt buộc.',
                'variant.*.stock_quantity.integer' => 'Số lượng biến thể phải là số nguyên.',
                'variant.*.stock_quantity.min' => 'Số lượng biến thể không được âm.',
                'variant.*.image_variant.image' => 'File tải lên phải là 1 hình ảnh.',
                'variant.*.image_variant.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif.',
                'variant.*.image_variant.max' => 'Kích thước ảnh không được vượt quá 2MB.',
            ]
        );

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/product', 'public'); // Lưu ảnh vào storage/app/public/images
        }else{
            $path = null;
        }
        // làm biến thể ảnh sản phẩm
        // $product = Product::create(array_merge(
        //     //array_merge để kết hợp thuộc tính khác và đường dẫn ảnh thành 1 mảng duy nhất
        //     $validated,
        //     ['image' => $path] // Thêm đường dẫn ảnh vào mảng
        // ));
        // cách 2 để thêm sản phẩm
        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            // 'discount' => $validated['discount'] ?? null,
            // 'stock_quantity' => $validated['stock_quantity'],
            'brand_id' => $validated['brand_id'],
            'category_id' => $validated['category_id'],
            // 'status'=> $validated['status'],
            'image' => $path, // Lưu đường dẫn ảnh vào cột 'image'
        ]);

            foreach ($validated['variant'] as $index=>$variant) {
                        $path_variant = null;
                    if (isset($variant['image_variant']) && $request->hasFile('variant.' . $index . '.image_variant')) {
                        $path_variant = $request->file('variant.' . $index . '.image_variant')->store('uploads/variants', 'public');
                    }
                ProductVariant::create([
                    'product_id' => $product->id,
                    'color_id' => $variant['color_id'],
                    'size_id' => $variant['size_id'],
                    // 'price' => $variant['price'],
                    'stock_quantity' => $variant['stock_quantity'],
                    'image_variant' => $path_variant // lưu vào bảng biến thể
                ]);
            }
        return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //

        $product = Product::with('variants','variants.color','variants.size','category')
        ->find($id);
        return view('admin.product.detail',compact('product'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $product = Product::with('variants')->findOrFail($id);
        $brands = Brand::all();
        $categories = Category::all();
        $colors = Color::all();
        $sizes = Size::all();

        return view('admin.product.update', compact('product', 'brands', 'categories', 'colors', 'sizes'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $product = Product::findOrFail($id);

    // Xử lý ảnh chính của sản phẩm
    if ($request->hasFile('image')) {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $path = $request->file('image')->store('upload/product', 'public');
    } else {
        $path = $product->image;
    }

    // Cập nhật thông tin sản phẩm
    $product->update([
        'name' => $request->input('name'),
        'description' => $request->input('description'),
        'price' => $request->input('price'),
        'brand_id' => $request->input('brand_id'),
        'category_id' => $request->input('category_id'),
        'image' => $path,
    ]);

    // Xử lý biến thể
    if ($request->variant) {
        foreach ($request->variant as $variantData) {
            if (isset($variantData['id'])) {
                // Cập nhật biến thể cũ
                $variant = ProductVariant::findOrFail($variantData['id']);

                // Kiểm tra ảnh biến thể
                if (isset($variantData['image_variant']) && $variantData['image_variant'] instanceof UploadedFile) {
                    // Xóa ảnh cũ nếu có
                    if ($variant->image_variant) {
                        Storage::disk('public')->delete($variant->image_variant);
                    }
                    // Lưu ảnh mới
                    $variantImagePath = $variantData['image_variant']->store('upload/variant', 'public');
                } else {
                    // Giữ nguyên ảnh cũ nếu không tải mới
                    $variantImagePath = $variant->image_variant;
                }

                // Cập nhật thông tin biến thể
                $variant->update([
                    'color_id' => $variantData['color_id'] ?? $variant->color_id,
                    'size_id' => $variantData['size_id'] ?? $variant->size_id,
                    'stock_quantity' => $variantData['stock_quantity'] ?? $variant->stock_quantity,
                    'image_variant' => $variantImagePath,
                ]);

            } else {
                // Thêm biến thể mới nếu không có id
                $variantImagePath = null;

                // Kiểm tra nếu có ảnh mới
                if (isset($variantData['image_variant']) && $variantData['image_variant'] instanceof UploadedFile) {
                    $variantImagePath = $variantData['image_variant']->store('upload/variant', 'public');
                }

                // Tạo mới biến thể
                ProductVariant::create([
                    'product_id' => $product->id,
                    'color_id' => $variantData['color_id'],
                    'size_id' => $variantData['size_id'],
                    'stock_quantity' => $variantData['stock_quantity'],
                    'image_variant' => $variantImagePath,
                ]);
            }
        }
    }

    return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm và biến thể thành công!');
}






    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //

    }
}
