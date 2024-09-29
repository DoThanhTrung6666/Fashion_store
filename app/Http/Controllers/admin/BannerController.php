<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index() {
        $banners = Banner::all();
        return view('admin.banners.index', compact('banners'));
    }

    public function create() {
        return view('admin.banners.create');
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $request->file('image')->store('banners', 'public');

        Banner::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $imagePath,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.banners.index')->with('success', 'Banner created successfully.');
    }

    public function edit(Banner $banner) {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner) {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($banner->image_path);
            $imagePath = $request->file('image')->store('banners', 'public');
        } else {
            $imagePath = $banner->image_path;
        }

        $banner->update([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $imagePath,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.banners.index')->with('success', 'Banner updated successfully.');
    }

    public function destroy(Banner $banner) {
        Storage::disk('public')->delete($banner->image_path);
        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', 'Banner deleted successfully.');
    }
}
