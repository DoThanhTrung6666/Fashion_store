<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Danh sách color
    public function index()
    {
        $colors = Color::all();
        return view('admin.color.index', compact('colors'));
    }

    // Hiển thị form tạo color mới
    public function create()
    {
        return view('admin.color.create');
    }

    // Lưu color mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Color::create($request->all());
        return redirect()->route('colors.index')->with('success', 'color created successfully.');
    }

    // Hiển thị form chỉnh sửa size
    public function edit(Color $color)
    {
        return view('colors.edit', compact('color'));
    }

    // Cập nhật size
    public function update(Request $request, Color $color)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $color->update($request->all());
        return redirect()->route('colors.index')->with('success', 'color updated successfully.');
    }

    // Xóa size
    public function destroy(Color $color)
    {
        $color->delete();
        return redirect()->route('colors.index')->with('success', 'color deleted successfully.');
    }
}
