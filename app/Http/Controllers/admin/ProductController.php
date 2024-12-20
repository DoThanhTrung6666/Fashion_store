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
// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $products = Product::with('variants','category','brand')
        ->where('status',1)
        ->orderBy('id', 'desc')
        ->paginate(10);
        return view('admin.product.index',compact('products'));
    }

    // danh sách ngừng kinh doanh
    public function listEndProduct(){
        $products = Product::with('variants','category')
        ->where('status',2)
        ->get();
        return view('admin.product.list-end-product',compact('products'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $colors = Color::where('status',1)->get();
        $sizes = Size::where('status',1)->get();
        $categorys = Category::all();
        $brands = Brand::where('status',1)->get();
        return view('admin.product.create',compact('colors','sizes','categorys','brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => 'required|string|max:255|unique:products,name',
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
                'name.unique' => 'Tên sản phẩm đã tồn tại',
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

        $variants = $request->input('variant', []);
        $uniqueVariants = collect($variants)->unique(function ($variant) {
            return $variant['color_id'] . '-' . $variant['size_id'];
        });

        if ($uniqueVariants->count() !== count($variants)) {
            return redirect()->back()
                ->withErrors(['variant' => 'Không được trùng lặp về màu sắc và kích thước.'])
                ->withInput();
                // ->with('error','Màu sắc và kích cỡ phải khác nhau hãy chọn lại');
        }

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
            'brand_id' => $validated['brand_id'],
            'category_id' => $validated['category_id'],
            'image' => $path,
            'status'=> 1, // mặc định là đang bán là 1 còn 2 là ngừng kinh doanh
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

    public function updateStatus($id){
        $product = Product::findOrFail($id);
        if($product->status == 1){
            $product->status = 2;
            $product->save();
        }elseif($product->status == 2){
            $product->status = 1;
            $product->save();
        }
        return redirect()->back()->with('success','Sản phẩm đã ngừng kinh doanh');
    }

    // thêm biến thể mới
    public function createVariant($productId)
    {
        $product = Product::findOrFail($productId);
        $colors = Color::all(); // Giả sử bạn có model Color
        $sizes = Size::all();   // Giả sử bạn có model Size

        return view('admin.product.create-variant', compact('product', 'colors', 'sizes'));
    }


// public function storeVariant(Request $request, $productId)
// {
//     $product = Product::findOrFail($productId);

//     $validator = Validator::make($request->all(), [
//         'variant.*.color_id' => 'required|exists:colors,id',
//         'variant.*.size_id' => 'required|exists:sizes,id',
//         'variant.*.stock_quantity' => 'required|integer|min:1',
//         'variant.*.image_variant' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
//     ]);

//     if ($validator->fails()) {
//         return redirect()
//             ->back()
//             ->withErrors($validator)
//             ->withInput();
//     }

//     $variants = $request->input('variant', []);
//     $images = $request->file('variant', []);

//     foreach ($variants as $key => $variant) {
//         $imagePath = null;

//         // Check if image exists for this variant
//         if (isset($images[$key]['image_variant'])) {
//             $image = $images[$key]['image_variant'];
//             $imagePath = $image->store('variants', 'public'); // Save to `storage/app/public/variants`
//         }

//         // Save variant to the database
//         $product->variants()->create([
//             'color_id' => $variant['color_id'],
//             'size_id' => $variant['size_id'],
//             'stock_quantity' => $variant['stock_quantity'],
//             'image_variant' => $imagePath,
//         ]);
//     }

//     return redirect()
//         ->route('admin.products.show', $product->id)
//         ->with('success', 'Biến thể đã được thêm thành công!');
// }


// public function storeVariant(Request $request)
// {
//     // Validate dữ liệu
//     $request->validate([
//         'variant.*.color_id' => [
//             'required',
//             'exists:colors,id',
//         ],
//         'variant.*.size_id' => [
//             'required',
//             'exists:sizes,id',
//         ],
//         'variant.*.stock_quantity' => 'required|integer|min:1',
//         'variant.*.image_variant' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
//     ]);

//     // Validate trùng tổ hợp (product_id, color_id, size_id)
//     foreach ($request->variant as $index => $variant) {
//         $rules = [
//             'product_id' => 'required|exists:products,id',
//             "variant.$index.color_id" => [
//                 'required',
//                 'exists:colors,id',
//                 Rule::unique('product_variants', 'color_id')
//                     ->where('size_id', $variant['size_id'])
//                     ->where('product_id', $request->product_id),
//             ],
//         ];

//         $messages = [
//             "variant.$index.color_id.unique" => 'Biến thể màu sắc và kích thước đã tồn tại.',
//         ];

//         // Apply thêm từng biến thể
//         validator(['variant' => $request->variant], $rules, $messages)->validate();
//     }

//     // Lưu dữ liệu biến thể
//     foreach ($request->variant as $variant) {
//         \DB::table('product_variants')->insert([
//             'product_id' => $request->product_id,
//             'color_id' => $variant['color_id'],
//             'size_id' => $variant['size_id'],
//             'stock_quantity' => $variant['stock_quantity'],
//             'image_variant' => $variant['image_variant'] ?? null,
//             'created_at' => now(),
//             'updated_at' => now(),
//         ]);
//     }

//     return redirect()->back()->with('success', 'Biến thể đã được thêm thành công.');
// }

// use Illuminate\Support\Facades\Validator;

public function storeVariant(Request $request, $productId)
{
    $product = Product::findOrFail($productId);

    $validator = Validator::make($request->all(), [
        'variant.*.color_id' => 'required|exists:colors,id',
        'variant.*.size_id' => 'required|exists:sizes,id',
        'variant.*.stock_quantity' => 'required|integer|min:1',
        'variant.*.image_variant' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($validator->fails()) {
        return redirect()
            ->back()
            ->withErrors($validator)
            ->withInput();
    }

    $variants = $request->input('variant', []);
    $images = $request->file('variant', []);

    foreach ($variants as $key => $variant) {
        // Kiểm tra trùng lặp trong database
        $exists = $product->variants()->where('color_id', $variant['color_id'])
            ->where('size_id', $variant['size_id'])
            ->exists();

        if ($exists) {
            // dd(123);
            return redirect()
                ->back()
                ->withErrors([
                    "variant.$key" => "Biến thể với màu sắc và kích thước này đã tồn tại.",
                ])
                ->withInput();
            // return redirect()->back()->with('error','Biến thể này đã tồn tại');
        }

        $imagePath = null;

        // Kiểm tra và lưu ảnh nếu có
        if (isset($images[$key]['image_variant'])) {
            $image = $images[$key]['image_variant'];
            $imagePath = $image->store('variants', 'public'); // Lưu tại `storage/app/public/variants`
        }

        // Lưu biến thể mới vào database
        $product->variants()->create([
            'color_id' => $variant['color_id'],
            'size_id' => $variant['size_id'],
            'stock_quantity' => $variant['stock_quantity'],
            'image_variant' => $imagePath,
        ]);
    }

    return redirect()
        ->route('admin.products.show', $product->id)
        ->with('success', 'Biến thể đã được thêm thành công!');
}


// tiến hành xoá biến thể
    public function deleteVariant($id){
        $variant = ProductVariant::find($id);
        if(!$variant){
            return redirect()->back()->withErrors(['error'=>'Biến thể không tồn tại .']);
        }
        if ($variant->image_variant && Storage::exists('public/' . $variant->image_variant)) {
            Storage::delete('public/' . $variant->image_variant);
        }
        $variant->delete();
        return redirect()->back()->with('success','Xoá thành công biến thể');
    }
// tìm kiếm sản phẩm
    public function search(Request $request){
        $search = $request->input('search');
        $products = Product::query();
        if($search){
            $products = $products->where('name','like','%'.$search.'%')
                                 ->orWhere('id','like','%'.$search.'%');
        }
        $products = $products->orderBy('id','desc')->paginate(10);
        return view('admin.product.index',compact('products'));
    }





}
