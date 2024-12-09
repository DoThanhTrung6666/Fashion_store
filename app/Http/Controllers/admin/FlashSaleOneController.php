<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;

class FlashSaleOneController extends Controller
{

    public function listProductFlashSale(){
        $flashSales = FlashSale::withCount('flashSaleItems')->get();
        return view('admin.flash-sale-one.list-product-flash-sale',compact('flashSales'));
    }
    public function listFlashSale(){
        $flashSales = FlashSale::with('flashSaleItems')->get();
        return view('admin.flash-sale-one.list-flash-sale',compact('flashSales'));
    }
    public function createFlashSale(){
        $sales = Sale::all();
        return view('admin.flash-sale-one.create',compact('sales'));
    }
    public function storeFlashSale(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sale_id' => 'required|integer',
            'start_time' => 'required|date|unique:flash_sales,start_time',
            'end_time' => 'required|date|after:start_time|unique:flash_sales,end_time',
        ],[
            'name.required' => 'Không được bỏ trống',
            'name.max' => 'Không được quá 255 kí tự',
            'sale_id.required' => 'Không được bỏ trống',
            'start_time.required' => 'Không được bỏ trống',
            'start_time.date' => 'Sai định dạng',
            'end_time.required' => 'Không được bỏ trống',
            'end_time.date' => 'Sai định dạng',
            'end_time.after' => 'Thời gian kết thúc phải lớn hơn thời gian bắt đầu'
        ]);
        FlashSale::create([
            'name' => $validated['name'],
            'sale_id' => $validated['sale_id'],
            'start_time' => $request['start_time'],
            'end_time' => $request['end_time'],
            'status' => 'active',
        ]);

        return redirect()->route('admin.listFlashSale')->with('success','FlashSale đã được tạo');
    }

    public function addProductsToFlashSale($flashSaleId){
        $flashSale =FlashSale::findOrFail($flashSaleId);
        $products = Product::whereDoesntHave('flashSaleItems', function ($query) use ($flashSaleId){
            $query->where('flash_sale_id',$flashSaleId);
        })->get();
        return view('admin.flash-sale-one.add-products-flash-sale',compact('flashSale','products'));
    }

    public function saveProductsToFlashSale(Request $request , $flashSaleId){
        // dd($request->all());

        $validated = $request->validate([
            'products_id' => 'required|array',
            'quantities' => 'required|array',
            'quantities.*' => 'integer|min:1',
        ]);


        $flashSale = FlashSale::findOrFail($flashSaleId);

        foreach ($validated['products_id'] as $productId){
            $quantity = $validated['quantities'][$productId] ?? 0;
            $product = Product::findOrFail($productId);

            FlashSaleItem::create([
                'flash_sale_id' => $flashSale->id,
                'product_id' => $product->id,
                'price' => $product->price * (1-$flashSale->sale_id/100),
                'flash_sale_quantity' => $quantity,
                'sold_quantity' => 0, // Bắt đầu với số lượng đã bán là 0
            ]);
        }
        return redirect()->route('admin.listFlashSale')->with('success','Sản phẩm đã được thêm vào FlashSale');
    }

    public function splienquan($flashSaleId){

        $flashSale = FlashSale::with('flashSaleItems')->findOrFail($flashSaleId);
        return view('admin.flash-sale-one.list-product-flash-sale', compact('flashSale'));
    }

    // xoá sản phẩm liên quan flash-sale

    public function deleteProduct($flashSaleId,$productId){
        $product = FlashSaleItem::findOrFail($productId);
        $product->delete();
        return redirect()->route('admin.view_products', $flashSaleId)->with('success', 'Sản phẩm đã được xóa.');

    }
}
