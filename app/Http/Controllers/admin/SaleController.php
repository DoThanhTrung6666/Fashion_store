<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = Sale::all();
        return view('admin.sale.list',compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.sale.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'discount_percentage' => 'required|integer|min:1|max:99',
        ],[
            'discount_percentage.required' => 'Không được bỏ trống',
            'discount_percentage.interger' => '% giảm giá phải là số',
            'discount_percentage.min' => '% giảm giá phải lớn hơn 1 và nhỏ hơn 100',
            'discount_percentage.max' => '% giảm giá phải lớn hơn 1 và nhỏ hơn 100',
        ]);
        Sale::create([
            'discount_percentage' => $validated['discount_percentage'],
        ]);
        return redirect()->route('admin.sales.index');
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
        $sale = Sale::findOrFail($id);
        return view('admin.sale.update',compact('sale'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validated = $request->validate([
            'discount_percentage' => 'required|integer|min:1|max:99',
        ], [
            'discount_percentage.required' => 'Không được bỏ trống',
            'discount_percentage.integer' => '% giảm giá phải là số',
            'discount_percentage.min' => '% giảm giá phải lớn hơn 1 và nhỏ hơn 100',
            'discount_percentage.max' => '% giảm giá phải lớn hơn 1 và nhỏ hơn 100',
        ]);

        $sale = Sale::findOrFail($id);
        $sale->update([
            'discount_percentage' => $validated['discount_percentage'],
        ]);

        return redirect()->route('admin.sales.index')->with('success', 'Cập nhật giảm giá thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
