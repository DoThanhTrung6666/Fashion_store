<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\ProductVariant;
use App\Models\Size;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function danhmucsp(Request $request)
    {
        // Lấy sản phẩm từ DB với eager loading để lấy thông tin sản phẩm
        $query = ProductVariant::with('product');

        // Lấy tất cả các màu
        $colors = Color::all();

        // Lấy tất cả các kích thước
        $sizes = Size::all();


        // Chỉ lọc nếu cả màu và kích thước đều được chọn
        if (
            $request->has('color') && $request->input('color') !== '' &&
            $request->has('size') && $request->input('size') !== ''
        ) {

            // Lọc theo màu sắc
            $query->where('color_id', $request->input('color'));

        // lọc theo danh mục
        $categories = Category::all();
        if ($request->has('category') && $request->category != '') {
            $query->whereHas('product.category', function($query) use ($request) {
                $query->where('id', $request->category);
            });
        }
        


            // Lọc theo kích thước
            $query->where('size_id', $request->input('size'));
        }

        // Kiểm tra nếu người dùng chọn lọc theo giá
        if ($request->has('sort_by')) {
            switch ($request->input('sort_by')) {
                case 2:
                    $query->orderBy('price', 'asc'); // Sắp xếp theo giá thấp đến cao
                    break;
                case 3:
                    $query->orderBy('price', 'desc'); // Sắp xếp theo giá cao đến thấp
                    break;
                case 'price_below_100':
                    $query->where('price', '<', 100000); // Lọc giá dưới 100.000 VNĐ
                    break;
                case 'price_100_500':
                    $query->whereBetween('price', [100000, 500000]); // Lọc giá từ 100.000 đến 500.000 VNĐ
                    break;
                case 'price_500_1000':
                    $query->whereBetween('price', [500000, 1000000]); // Lọc giá từ 500.000 đến 1.000.000 VNĐ
                    break;
                case 'price_above_1000':
                    $query->where('price', '>', 1000000); // Lọc giá trên 1.000.000 VNĐ
                    break;
                default:
                    $query->latest(); // Mặc định sắp xếp mới nhất
                    break;
            }
        }

        // Nhóm các biến thể theo product_id và tính khoảng giá thấp nhất - cao nhất
        $products = $query->get()->groupBy('product_id')->map(function ($variants) {
            $minPrice = $variants->min('price');
            $maxPrice = $variants->max('price');
            $product = $variants->first(); // Sử dụng một biến thể để lấy thông tin sản phẩm ban đầu
            $product->min_price = $minPrice;
            $product->max_price = $maxPrice;
            return $product;
        })->values();


        return view('client.danhmucsp', compact('products', 'sizes', 'colors', 'categories')); // Truyền dữ liệu sản phẩm và kích thước vào view

    }
}
