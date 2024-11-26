<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthenticationController extends Controller
{
    //
    public function showFormLogin()
    {
        return view('client.auth.login');
    }

    public function login(Request $request)
    {
        $login = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ],
            [
                'email.required'=>'Không được bỏ trống',
                'email.email'=>'Bạn cần nhập đúng định dạng',
                'password.required' =>'Không được bỏ trống'
            ]);

        if (Auth::attempt($login)) {
            $request->session()->regenerate();
            return redirect()->route('home');
        }
        return redirect()->back()->with('error','Sai thông tin tài khoản hoặc mật khẩu');
    }
    public function showFormRegister()
    {
        return view('client.auth.register');
    }
    public function register(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|min:8|'
        ],[
            'name.required'=>'Không được bỏ trống tên',
            'name.string'=>'Tên phải là chuỗi ký tự',
            'email.required'=>'Không được bỏ trống email',
            'email.unique'=>'Email này đã được sử dụng',
            'password.required'=>'Không được bỏ trống password',
            'password.min'=>'Mật khẩu phải ít nhất 8 ký tự'
        ]);
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => 2,
        ]);
        return redirect()->back()->with('success','Đăng kí thành công tài khoản');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function edit(){
        $user = Auth::user();
        return view('client.auth.profile',compact('user'));
    }
    public function update(Request $request)
{
    // Validate dữ liệu đầu vào
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . auth()->id(),
        'phone' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|max:15',
        'address' => 'nullable|string|max:255',
        'password' => 'nullable|min:8',
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ], [
        'name.required' => 'Tên không được bỏ trống',
        'email.required' => 'Email không được bỏ trống',
        'email.email' => 'Vui lòng nhập email hợp lệ',
        'email.unique' => 'Email này đã tồn tại',
        'phone.regex' => 'Số điện thoại không hợp lệ',
        'address.max' => 'Địa chỉ không được quá 255 ký tự',
        'password.min' => 'Mật khẩu phải ít nhất 8 ký tự',
        'avatar.image' => 'Tệp tải lên phải là hình ảnh',
        'avatar.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif, svg',
        'avatar.max' => 'Dung lượng ảnh không được vượt quá 2MB',
    ]);

    // Lấy người dùng hiện tại
    $user = Auth::user();

    if ($request->hasFile('avatar')) {
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }
        $validated['avatar'] = $request->file('avatar')->store('uploads/user', 'public');
    } else {
        $validated['avatar'] = $user->avatar;
    }
    // Cập nhật thông tin người dùng
    $user->name = $validated['name'];
    $user->email = $validated['email'];
    $user->phone = $validated['phone'] ?? $user->phone; // Nếu có số điện thoại mới thì cập nhật, nếu không giữ nguyên
    $user->address = $validated['address'] ?? $user->address; // Cập nhật địa chỉ nếu có, nếu không giữ nguyên
    $user->avatar = $validated['avatar'];

    // Xử lý mật khẩu (nếu có thay đổi)
    if (!empty($validated['password'])) {
        $user->password = Hash::make($validated['password']);
    }

    // Lưu lại thay đổi
    $user->save();


    // Chuyển hướng và thông báo thành công
    return redirect()->back()->with('success', 'Cập nhật tài khoản thành công!');
}


}
