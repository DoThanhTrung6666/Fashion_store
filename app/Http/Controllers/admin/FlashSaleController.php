<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Sale;
use Illuminate\Http\Request;

class FlashSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $flashSales = FlashSale::with(['productVariant','sale'])->get();
        $sales = Sale::all();
        return view('admin.flash-sale.index',compact('flashSales','sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $products = Product::all();
        $sales = Sale::all();
        return view('admin.flash-sale.create', compact('products', 'sales'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // dd($request->all());
    $validated = $request->validate([
        'product_variant_id' => 'required|exists:products,id',
        'sale_id' => 'required|exists:sales,id',
        'start_time' => 'required|date',
        'end_time' => 'required|date|after:start_time',
        'status' => 'required|in:active,inactive',
    ]);

    $productVariants=ProductVariant::where('product_id',$validated['product_variant_id'])->get();

    // Lưu flash sale vào database
    foreach($productVariants as $variant){
    FlashSale::updateOrCreate(
        ['product_variant_id' => $variant->id],
        [
            'sale_id' => $validated['sale_id'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'status' => $validated['status'],
        ]
    );
    }
    return redirect()->back()->with('success', 'Áp dụng thành công cho sản phẩm!');
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
