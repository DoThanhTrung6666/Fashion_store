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
}
