<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index() {

        $banners = Banner::query()->latest('id')->paginate(10);
        return view('admin.banners.index', compact('banners'));
       
    }

    public function create() {
        return view('admin.banners.create');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image_path' => 'required|max:255',  // Assuming it's a string representing the file path
            'link' => 'nullable|url|max:255',
            'position' => 'integer|min:0',
            'start_date' => 'nullable|date|after_or_equal:today',  // Must be today or later
            'end_date' => 'nullable|date|after:start_date',  // Must be after start date
            'is_active' => 'boolean',
        ]);

        $path_image = $request->file('image_path')->store('images');
        $data['image_path'] = $path_image;
        Banner::query()->create($data);

        return redirect()->route('banners.index')->with('success', 'Banner created successfully.');
    }

    public function edit(Banner $banner) {
        return view('admin.banners.update', compact('banner'));
    }

    public function update(Request $request, Banner $banner) {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            
            'link' => 'nullable|url|max:255',
            'position' => 'integer|min:0',
            'start_date' => 'nullable|date|after_or_equal:today',  // Must be today or later
            'end_date' => 'nullable|date|after:start_date',  // Must be after start date
            'is_active' => 'boolean',
        ]);

        $data['image_path'] = $banner->image_path;
        if ($request->hasFile('image_path')) {
            if (file_exists('storage/' . $banner->image_path)) {
                unlink('storage/' . $banner->image_path);
            }
            $path_image = $request->file('image_path')->store('images');
            $data['image_path'] = $path_image;
        }
        $banner->update($data);

        return redirect()->route('banners.index')->with('success', 'Banner updated successfully.');
    }

    public function destroy(Banner $banner) {

        if (file_exists('storage/' . $banner->image_path)) {
            unlink('storage/' . $banner->image_path);
        }
        $banner->delete();

        return redirect()->route('banners.index')->with('success', 'Banner deleted successfully.');
    }
}
