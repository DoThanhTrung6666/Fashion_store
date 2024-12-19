<?php

namespace App\Http\Controllers\shipper;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Auth\Authenticatable;
class ShipperController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $orders = Order::where('shipper_id',1)
            ->whereIn('status',['Vận chuyển','Chờ giao hàng','Đã giao','Hoàn thành','Đã xác nhận'])
            ->get();
        return view('shipper.list',compact('orders'));
    }

    public function index2(){
        return view('shipper.index');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $detailOrder = Order::find($id);
        return view('shipper.detail',compact('detailOrder'));
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
        $order = Order::where('id',$id)
                      ->where('shipper_id',1)
                      ->firstOrFail();
        $order->update([
            'status'=>'Đang vận chuyển'
        ]);
        return redirect()->back()->with('success','Trạng thái đơn hàng được cập nhật');

    }
    public function update2(Request $request, string $id)
    {
        //
        $order = Order::where('id',$id)
                      ->where('shipper_id',1)
                      ->firstOrFail();
        $order->update([
            'status'=>'Đã giao'
        ]);
        return redirect()->back()->with('success','Trạng thái đơn hàng được cập nhật');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function loginShowFormShipper(){
        return view('shipper.login');
    }
    public function loginShipper(Request $request){
        $login = $request->only('email','password');
        // dd($login);
        if(Auth::guard('shipper')->attempt($login)){
            // dd(123);
            return redirect()->route('shipper.orders.index2');
        }
        return back()->with('error','Thông tin đăng nhập không chính xác');
    }


}
