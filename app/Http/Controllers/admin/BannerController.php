<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {

        $banners = Banner::query()->latest('id')->paginate(10);
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image_path' => 'required|file|image|mimes:jpeg,png,jpg,gif,svg|max:3048',
            'link' => 'nullable|url|max:255',
            'position' => 'integer|min:0|max:5',
            'start_date' => 'nullable|date|after_or_equal:today',
            'end_date' => 'nullable|date|after:start_date',
            'is_active' => 'boolean',
        ], [
            'title.max' => 'Tiêu đề không được dài quá 255 ký tự.',
            'description.string' => 'Mô tả phải là một chuỗi ký tự.',
            'image_path.required' => 'Vui lòng chọn một ảnh.',
            'image_path.file' => 'Tệp tải lên phải là một tệp.',
            'image_path.image' => 'Tệp phải là một hình ảnh.',
            'image_path.mimes' => 'Ảnh chỉ được có định dạng: jpeg, png, jpg, gif, svg.',
            'image_path.max' => 'Kích thước ảnh không được vượt quá 3MB.',
            'link.url' => 'Liên kết không đúng định dạng URL.',
            'link.max' => 'Liên kết không được dài quá 255 ký tự.',
            'position.integer' => 'Vị trí phải là một số nguyên.',
            'position.min' => 'Vị trí phải lớn hơn hoặc bằng 0.',
            'position.max' => 'Vị trí bé hơn hoặc bằng 4.',
            'start_date.date' => 'Ngày bắt đầu phải là một ngày hợp lệ.',
            'start_date.after_or_equal' => 'Ngày bắt đầu phải từ hôm nay trở đi.',
            'end_date.date' => 'Ngày kết thúc phải là một ngày hợp lệ.',
            'end_date.after' => 'Ngày kết thúc phải sau ngày bắt đầu.',
            'is_active.boolean' => 'Trạng thái kích hoạt phải là đúng hoặc sai.',
        ]);
        $data['is_active'] = $request->has('is_active');

        $path_image = $request->file('image_path')->store('images');
        $data['image_path'] = $path_image;
        Banner::query()->create($data);

        return redirect()->route('admin.banners.index')->with('success', 'Banner created successfully.');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.update', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
{
    $data = $request->validate([
        'title' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'image_path' => 'nullable|file|image|mimes:jpeg,png,jpg,gif,svg|max:3048', // Cho phép nullable
        'link' => 'nullable|url|max:255',
        'position' => 'integer|min:0|max:4',
        'start_date' => 'nullable|date|after_or_equal:today',
        'end_date' => 'nullable|date|after:start_date',
        
        
    ], [
        'title.max' => 'Tiêu đề không được dài quá 255 ký tự.',
        'description.string' => 'Mô tả phải là một chuỗi ký tự.',
        'image_path.file' => 'Tệp tải lên phải là một tệp.',
        'image_path.image' => 'Tệp phải là một hình ảnh.',
        'image_path.mimes' => 'Ảnh chỉ được có định dạng: jpeg, png, jpg, gif, svg.',
        'image_path.max' => 'Kích thước ảnh không được vượt quá 3MB.',
        'link.url' => 'Liên kết không đúng định dạng URL.',
        'link.max' => 'Liên kết không được dài quá 255 ký tự.',
        'position.integer' => 'Vị trí phải là một số nguyên.',
        'position.min' => 'Vị trí phải lớn hơn hoặc bằng 0.',
        'position.max' => 'Vị trí bé hơn hoặc bằng 4.',
        'start_date.date' => 'Ngày bắt đầu phải là một ngày hợp lệ.',
        'start_date.after_or_equal' => 'Ngày bắt đầu phải từ hôm nay trở đi.',
        'end_date.date' => 'Ngày kết thúc phải là một ngày hợp lệ.',
        'end_date.after' => 'Ngày kết thúc phải sau ngày bắt đầu.',
        
    ]);

   

  // Xử lý trạng thái is_active (chuyển 'on' thành 1 hoặc 0)
  $data['is_active'] = $request->has('is_active') ? 1 : 0;

  // Xử lý ảnh nếu có
  if ($request->hasFile('image_path')) {
      if (file_exists(storage_path('app/' . $banner->image_path))) {
          unlink(storage_path('app/' . $banner->image_path)); // Xóa ảnh cũ
      }
      $data['image_path'] = $request->file('image_path')->store('images'); // Lưu ảnh mới
  } else {
      $data['image_path'] = $banner->image_path; // Giữ ảnh cũ
  }

  // Chuyển đổi ngày giờ về định dạng đúng cho MySQL
  if ($request->start_date) {
      $data['start_date'] = \Carbon\Carbon::parse($request->start_date)->format('Y-m-d H:i:s');
  }

  if ($request->end_date) {
      $data['end_date'] = \Carbon\Carbon::parse($request->end_date)->format('Y-m-d H:i:s');
  }

  $banner->update($data);

  return redirect()->route('admin.banners.index')->with('success', 'Cập nhật banner thành công!');
}


    public function destroy(Banner $banner)
    {

        if (file_exists('storage/' . $banner->image_path)) {
            unlink('storage/' . $banner->image_path);
        }
        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', 'Banner deleted successfully.');
    }
}
