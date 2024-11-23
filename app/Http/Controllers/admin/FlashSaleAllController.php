<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;

class FlashSaleAllController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $products = Product::all();
        $sales = Sale::all();
        return view('admin.flash-sale.createall',compact('products','sales'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate(
    [
        'sale_id' => 'required|exists:sales,id',
        'start_time' => 'required|date',
        'end_time' => 'required|date|after:start_time',
    ],
    [
        'sale_id.required' => 'Sale ID là bắt buộc.',
        'sale_id.exists' => 'Sale ID không tồn tại trong cơ sở dữ liệu.',
        'start_time.required' => 'Thời gian bắt đầu là bắt buộc.',
        'start_time.date' => 'Thời gian bắt đầu phải là một ngày hợp lệ.',
        'end_time.required' => 'Thời gian kết thúc là bắt buộc.',
        'end_time.date' => 'Thời gian kết thúc phải là một ngày hợp lệ.',
        'end_time.after' => 'Thời gian kết thúc phải sau thời gian bắt đầu.',
    ]);

    // Lấy tất cả sản phẩm
    $products = Product::all();

    foreach ($products as $product) {
        foreach ($product->variants as $variant) {
            // Áp dụng Flash Sale cho từng biến thể của sản phẩm
            FlashSale::updateOrCreate(
                ['product_variant_id' => $variant->id],
                [
                    'sale_id' => $validated['sale_id'],
                    'start_time' => $validated['start_time'],
                    'end_time' => $validated['end_time'],
                ]
            );
        }
    }

    return redirect()->back()->with('success', 'Flash Sale đã được áp dụng cho toàn bộ sản phẩm!');
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
