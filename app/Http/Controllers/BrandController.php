<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::query()->latest('id')->paginate(10);
        return view('admin.brand.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255', // Xác thực trường name
            'logo' => 'required', // Chú ý sửa 'logobrand' thành 'logo'
            'description' => 'nullable|string', // Xác thực trường description
            'country' => 'nullable|string', // Xác thực trường address
            'website_url' => 'required',
        ]);
        $data['slug'] = Str::slug($data['name'], '-');
        $path_logo = $request->file('logo')->store('images');
        $data['logo'] = $path_logo;
        Brand::query()->create($data);
        return redirect()->route('brands.index');
        // dd($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        return view('admin.brand.update', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255', // Xác thực trường name
            'logo' => 'nullable|image', // Chú ý sửa 'logobrand' thành 'logo'
            'description' => 'nullable|string', // Xác thực trường description
            'country' => 'nullable|string', // Xác thực trường address
            'website_url' => 'required',
        ]);
        $data['slug'] = Str::slug($data['name'], '-');
        $data['logo'] = $brand->logo;
        if ($request->hasFile('logo')) {
            if (file_exists('storage/' . $brand->logo)) {
                unlink('storage/' . $brand->logo);
            }
            $path_logo = $request->file('logo')->store('images');
            $data['logo'] = $path_logo;
        }
        $brand->update($data);
        return redirect()->route('brands.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        // Kiểm tra xem cột logo có dữ liệu hay không và file có tồn tại hay không
        if ($brand->logo && file_exists(public_path('storage/' . $brand->logo))) {
            unlink(public_path('storage/' . $brand->logo)); // Xóa ảnh nếu tồn tại
        }

        // Xóa bản ghi Brand
        $brand->delete();

        return redirect()->route('brands.index');
    }
}
