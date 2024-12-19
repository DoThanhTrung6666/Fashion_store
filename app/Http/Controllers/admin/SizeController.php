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
        $sizes = Size::where('status',1)->get();
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
            'name' => 'required|string|max:255|unique:sizes,name',
        ],
        [
            'name.unique' => 'Kích cỡ đã tồn tại',
           'name.required' => 'Tên kích cỡ là bắt buộc',
           'name.max' => 'Tên kích cỡ  không được dài hơn 255 ký tự.',
        ]);

        Size::create($request->all());
        return redirect()->route('admin.sizes.index')->with('success', 'Thêm mới thành công.');
    }

    // Hiển thị form chỉnh sửa size
    public function edit(Size $size)
    {
        return view('admin.size.update', compact('size'));
    }

    // Cập nhật size
    public function update(Request $request, Size $size)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:sizes,name',
        ],[
            'name.unique' => 'Kích cỡ đã tồn tại',
            'name.required' => 'Tên kích cỡ là bắt buộc',
            'name.max' => 'Tên kích cỡ  không được dài hơn 255 ký tự.',
         ]);

        $size->update($request->all());
        return redirect()->route('admin.sizes.index')->with('success', 'Cập nhật thành công.');
    }

    // Xóa size
    public function destroy(Size $size)
    {
        $size->delete();
        return redirect()->route('admin.sizes.index')->with('success', 'Xóa thành công.');
    }

    public function updateStatus($id){
        $size = Size::find($id);
        if($size){
            $size->status = 2;
            $size->save();
        }
        return redirect()->back()->with('success','Đã ngừng hoạt động');
    }
}
