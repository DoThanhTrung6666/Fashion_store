<?php


namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Size;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function danhmucsp(Request $request)
    {
        $query = Product::with('variants');

        // Lấy tất cả các màu
        $colors = Color::all();

        if ($request->has('color')) {
            $query->whereHas('variants', function ($q) use ($request) {
                $q->where('color_id', $request->input('color'));
            });
        }

        $sizes = Size::all();

        $categories = Category::all();
        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('id', $request->category);
            });
        }

        if ($request->has('size')) {
            $query->whereHas('variants', function ($q) use ($request) {
                $q->where('size_id', $request->input('size'));
            });
        }

        if ($request->has('sort_by')) {
            switch ($request->input('sort_by')) {
                case 2:
                    $query->orderBy('price', 'asc');
                    break;
                case 3:
                    $query->orderBy('price', 'desc');
                    break;
                case 'price_below_100':
                    $query->whereHas('variants', function ($q) {
                        $q->where('price', '<', 100000);
                    });
                    break;
                case 'price_100_500':
                    $query->whereHas('variants', function ($q) {
                        $q->whereBetween('price', [100000, 500000]);
                    });
                    break;
                case 'price_500_1000':
                    $query->whereHas('variants', function ($q) {
                        $q->whereBetween('price', [500000, 1000000]);
                    });
                    break;
                case 'price_above_1000':
                    $query->whereHas('variants', function ($q) {
                        $q->where('price', '>', 1000000);
                    });
                    break;
                default:
                    $query->latest();
                    break;
            }
        }

        $products = $query->get();

        return view('client.danhmucsp', compact('products', 'sizes', 'colors', 'categories'));
    }
}

