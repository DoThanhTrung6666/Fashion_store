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
        $shipperId = auth('shipper')->user()->id;
        $orders = Order::where('shipper_id',$shipperId)
            ->whereIn('status',['Vận chuyển','Đang vận chuyển','Đã giao','Hoàn thành'])
            ->get();
        return view('shipper.list',compact('orders'));
    }
    public function donhoanthanh()
    {
        //
        $shipperId = auth('shipper')->user()->id;
        $orders = Order::where('shipper_id',$shipperId)
            ->where('status','Hoàn thành')
            ->get();
        return view('shipper.listdonhoanthanh',compact('orders'));
    }
    public function index2(){
        if (auth('shipper')->check()) {
            // Lấy ID của shipper đang đăng nhập
            $shipperId = auth('shipper')->user()->id;

            // Đếm tổng số đơn hàng giao cho shipper này
            // $totalOrders = Order::where('shipper_id', $shipperId)->count();
            $totalOrders  = Order::where('shipper_id', $shipperId)
                                    ->whereIn('status',['Vận chuyển','Đang vận chuyển','Đã giao'])
                                    ->count();
            $totalOrdersHoanthanh  = Order::where('shipper_id', $shipperId)
                                    ->where('status','Hoàn thành')
                                    ->count();
            $totalMoney = Order::where('shipper_id', $shipperId)
                                    ->where('status', 'Hoàn thành')
                                    ->sum('total_amount');
            // Trả về kết quả (có thể là view hoặc API response)
            return view('shipper.index', compact('totalMoney','totalOrders','totalOrdersHoanthanh')); // Hoặc có thể return response dạng JSON nếu cần
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
    public function show(Order $order,string $id)
    {
        //
        if (auth('shipper')->check()) {
        $shipperId = auth('shipper')->user()->id;
        $detailOrder = Order::with('orderItems.productVariant.product')
        ->where('shipper_id', $shipperId)
        // ->where('id',$order)
        ->find($id);
        // }
        if(!$detailOrder){
            return redirect()->route('shipper.orders.index2');
        }
        return view('shipper.detail',compact('detailOrder'));
        // }else{
        //     return redirect()->route('login.shipper');
        }

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
        if (auth('shipper')->check()) {
            $shipperId = auth('shipper')->user()->id;
            $order = Order::where('id',$id)
                      ->where('shipper_id',$shipperId)
                      ->firstOrFail();
            $order->update([
            'status'=>'Đang vận chuyển'
        ]);
        }

        return redirect()->back()->with('success','Trạng thái đơn hàng được cập nhật');

    }
    public function update2(Request $request, string $id)
    {
        //
        if (auth('shipper')->check()) {
            $shipperId = auth('shipper')->user()->id;
            $order = Order::where('id',$id)
                      ->where('shipper_id',$shipperId)
                      ->firstOrFail();
            $order->update([
            'status'=>'Đã giao'
        ]);
        }

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
// Hiển thị form đổi mật khẩu
public function showChangePasswordForm()
{
    return view('shipper.changepassword'); // Tạo view cho form đổi mật khẩu
}

// Xử lý đổi mật khẩu
public function changePassword(Request $request)
{
    // Kiểm tra xác thực của shipper
    $shipper = auth('shipper')->user();

    // Validate dữ liệu
    $request->validate([
        'current_password' => 'required|string',
        'new_password' => 'required|string|min:6|confirmed', // Confirmed giúp so sánh mật khẩu mới và xác nhận mật khẩu mới
    ],[
        'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
        'current_password.string' => 'Mật khẩu hiện tại phải là chuỗi ký tự.',
        'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
        'new_password.string' => 'Mật khẩu mới phải là chuỗi ký tự.',
        'new_password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự.',
        'new_password.confirmed' => 'Mật khẩu mới và mật khẩu xác nhận không khớp.',
    ]);

    // Kiểm tra mật khẩu hiện tại có đúng không
    if (!Hash::check($request->current_password, $shipper->password)) {
        return redirect()->back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng.']);
    }

    // Cập nhật mật khẩu mới
    $shipper->password = Hash::make($request->new_password);
    $shipper->save();

    // Quay lại với thông báo thành công
    return redirect()->back()->with('success', 'Mật khẩu đã được thay đổi thành công!');
}
public function logout()
{
    // Đăng xuất shipper
    auth('shipper')->logout();

    // Điều hướng về trang đăng nhập với thông báo
    return redirect()->route('login.shipper')->with('success', 'Bạn đã đăng xuất thành công.');
}

}
