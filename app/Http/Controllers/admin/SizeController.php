<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Danh sách size
    public function index()
    {
        $sizes = Size::all();
        return view('admin.size.index', compact('sizes'));
    }

    // Hiển thị form tạo size mới
    public function create()
    {
        return view('admin.size.create');
    }

    // Lưu size mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Size::create($request->all());
        return redirect()->route('admin.sizes.index')->with('success', 'Size created successfully.');
    }

    // Hiển thị form chỉnh sửa size
    public function edit(Size $size)
    {
        return view('admin.sizes.edit', compact('size'));
    }

    // Cập nhật size
    public function update(Request $request, Size $size)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $size->update($request->all());
        return redirect()->route('admin.sizes.index')->with('success', 'Size updated successfully.');
    }

    // Xóa size
    public function destroy(Size $size)
    {
        $size->delete();
        return redirect()->route('admin.sizes.index')->with('success', 'Size deleted successfully.');
    }
}
