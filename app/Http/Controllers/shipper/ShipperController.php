<?php

namespace App\Http\Controllers\shipper;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Shipper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Auth\Authenticatable;
// use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Validator;

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
        if (auth('shipper')->check()) {
            // Lấy ID của shipper đang đăng nhập
            $shipperId = auth('shipper')->user()->id;
    
            // Đếm tổng số đơn hàng giao cho shipper này
            $totalOrders = Order::where('shipper_id', $shipperId)->count();
     
            // Trả về kết quả (có thể là view hoặc API response)
            return view('shipper.index', compact('totalOrders')); // Hoặc có thể return response dạng JSON nếu cần
        } else {
            // Nếu shipper chưa đăng nhập, chuyển hướng đến trang đăng nhập
            return redirect()->route('shipper.login');
        }
        // return view('shipper.index');
    }
    /**
     * Show the form for creating a new resource.
     */
 

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


    public function registerShowFormShipper(){
        return view('shipper.register');
    }

    public function registerShipper(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:shippers,email',
            'password' => 'required|string|min:6',
            // 'gender' => 'required|in:male,female,other',
            // 'date_of_birth' => 'required|date',
            'phone_number' => 'required|string|max:15',
        ]);

        Shipper::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'phone_number' => $request->phone_number,
        ]);

        return redirect()->back()->with('success', 'Đăng ký thành công!');
    }
    public function listShipper(){
        $shipper = Shipper::all();
        return view('shipper.listshipper',compact('shipper'));
    }
    public function getTotalOrders()
{
    if (auth('shipper')->check()) {
        // Lấy ID của shipper đang đăng nhập
        $shipperId = auth('shipper')->user()->id;

        // Đếm tổng số đơn hàng giao cho shipper này
        $totalOrders = Order::where('shipper_id', $shipperId)->count();

        // Trả về kết quả (có thể là view hoặc API response)
        return view('shipper.indexindex', compact('totalOrders')); // Hoặc có thể return response dạng JSON nếu cần
    } else {
        // Nếu shipper chưa đăng nhập, chuyển hướng đến trang đăng nhập
        return redirect()->route('shipper.login');
    }
}
}
