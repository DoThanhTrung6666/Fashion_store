<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Sale;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class FlashSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $flashSales = FlashSale::with('product','sale') // Lấy thông tin của sale liên quan
                           ->where('start_time', '<=', now())  // Sale đã bắt đầu
                           ->where('end_time', '>=', now())  // Sale chưa kết thúc
                           ->get();
        $sales = Sale::all();
        return view('admin.flash-sale.index',compact('flashSales','sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createSelectFlashSale()
    {
        //
        $products = Product::all();
        $sales = Sale::all();
        return view('admin.flash-sale.select-flash-sale', compact('products', 'sales'));
    }

    public function storeSelectFlashSale(Request $request){
        $validated = $request->validate([
            'products' => 'required|array|min:1',
        ],[
            'products.required' => 'Chọn ít nhất 1 sản phẩm'
        ]);
        session(['selectFlashSale' => $validated['products']]);

        return redirect()->back()->with('success','Chọn thành công');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create()
    {
        //
        $selectedProducts = session('selectFlashSale');

        //quay lại trang chọn khi không có sản phẩm nào được chọn
        if(!$selectedProducts){
            return redirect()->route('admin.flash-sale.select');
        }
        // lấy thông tin
        $products = Product::whereIn('id',$selectedProducts)->paginate(5);
        // sau đó lấy các loại giảm giá
        $sales = Sale::all();

        return view('admin.flash-sale.create-flash-sale',compact('products','sales'));

    }
    public function store(Request $request)
    {
        // Validate input data
        $validated = $request->validate([
            'sale_id' => 'required|exists:sales,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'status' => 'required|in:active,inactive',
        ],[
            'sale_id.required'=>"Không được bỏ trống trường này",
        ]);


        // Kiểm tra nếu đã có một flash sale nào đó tồn tại với thời gian bắt đầu và kết thúc giống như sản phẩm mới
    $selectedProducts = session('selectFlashSale'); // Lấy các sản phẩm đã chọn từ session

        // Lưu Flash Sale cho mỗi sản phẩm
        // foreach ($selectedProducts as $productId) {
        //     $productVariants = ProductVariant::where('product_id', $productId)->get();

            foreach ($selectedProducts as $variant) {
                FlashSale::updateOrCreate(
                    ['product_id' => $variant],
                    [
                        'sale_id' => $validated['sale_id'],
                        'start_time' => $validated['start_time'],
                        'end_time' => $validated['end_time'],
                        'status' => $validated['status'],
                    ]
                );
            }
        // }

        // Xóa session sau khi đã lưu Flash Sale
        session()->forget('selectFlashSale');


        return redirect()->route('admin.flash-sales.index')->with('success', 'Flash Sale đã được tạo thành công!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $flashSale = FlashSale::find($id);

    // Kiểm tra nếu tìm thấy Flash Sale
    if ($flashSale) {
        $flashSale->delete();
        return redirect()->route('admin.flash-sales.index')->with('success', 'Flash Sale đã được xóa thành công!');
    }
    return redirect()->route('admin.flash-sales.index')->with('error', 'Flash Sale không tồn tại!');
}

}
