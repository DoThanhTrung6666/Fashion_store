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
        $request->validate(
        [
            'name' => 'required|string|max:255',
        ],
        [
           'name.required' => 'Tên màu sắc là bắt buộc',
           'name.max' => 'Tên màu sắc không được dài hơn 255 ký tự.',
        ]
    );

        Color::create($request->all());
        return redirect()->route('admin.colors.index')->with('success', 'Thêm mới thành công.');
    }

    // Hiển thị form chỉnh sửa size
    public function edit(Color $color)
    {
        return view('admin.color.update', compact('color'));
    }

    // Cập nhật size
    public function update(Request $request, Color $color)
    {
        $request->validate(
            [
            'name' => 'required|string|max:255',
        ],
        [
            'name.required' => 'Tên màu sắc là bắt buộc',
            'name.max' => 'Tên màu sắc không được dài hơn 255 ký tự.',
         ]);

        $color->update($request->all());
        return redirect()->route('admin.colors.index')->with('success', 'Cập nhật thành công .');
    }

    // Xóa size
    public function destroy(Color $color)
    {
        $color->delete();
        return redirect()->route('admin.colors.index')->with('success', 'color deleted successfully.');
    }

    // xóa mềm 
    public function updateStatus($id){
        $color = Color::find($id);
        if($color){
            $color->status = 2;
            $color->save();
        }
        return redirect()->back()->with('success','Đã ngừng hoạt động');
    }
}
