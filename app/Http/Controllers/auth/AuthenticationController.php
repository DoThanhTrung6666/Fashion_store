<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Mail\mailPassword;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Mail;
use Nette\Utils\Random;

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
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => 2,
        ]);
        event(new Registered($user));

        return redirect()->back()->with('success','Đăng kí thành công tài khoản');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }

    public function edit(){
        $user = Auth::user();
        return view('client.auth.profile',compact('user'));
    }
    public function update(Request $request)
{
    // dd(123);
    $user = Auth::user();
    if(!$user){
        return redirect()->route('/');
    }
    // Validate dữ liệu đầu vào
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . auth()->id(),
        'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|max:15|min:10',
        'address' => 'required|string|max:255',
        // 'password' => 'nullable|min:8',
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ], [
        'name.required' => 'Tên không được bỏ trống',
        'email.required' => 'Email không được bỏ trống',
        'email.email' => 'Vui lòng nhập email hợp lệ',
        'email.unique' => 'Email này đã tồn tại',
        'phone.required' => 'Không được bỏ trống',
        'phone.regex' => 'Số điện thoại không hợp lệ',
        'phone.max' => 'Số điện thoại tối đa 15 số',
        'phone.min' => 'Số điện thoại phải là 10 số',
        'address.required' => 'Không được bỏ trống',
        'address.max' => 'Địa chỉ không được quá 255 ký tự',
        'password.min' => 'Mật khẩu phải ít nhất 8 ký tự',
        'avatar.image' => 'Tệp tải lên phải là hình ảnh',
        'avatar.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif, svg',
        'avatar.max' => 'Dung lượng ảnh không được vượt quá 2MB',
    ]);

    // Lấy người dùng hiện tại

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


    public function showForgotPassword()
    {
        return view('client.auth.forgotPassword');
    }

    public function forgotPassword(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);
        $email = $request->email;
        $time = Carbon::now();
        $otp = rand(100000, 999999);
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            [
                'token' => Hash::make($otp),
                'created_at' => $time
            ],
        );
        Mail::to($email)->send(new mailPassword($otp, $email));
        return redirect()->route('showResetPassword', ['email' => $email])->with('Mã OTP đã được gửi đến Email của bạn!');
    }

    public function showResetPassword(string $email)
    {
        return view('client.auth.resetPassword', compact('email'));
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $email = $request->email;
        $user = User::where('email', $email)->first();
        $otp = $request->otp;
        $password = $request->password;
        $passwordResest = DB::table('password_reset_tokens')->where('email', $email)->first();
        $expiryTime = Carbon::parse($passwordResest->created_at)->addMinutes(5);

        if (Carbon::now()->greaterThan($expiryTime)) {
            return back()->with('error', 'Mã OTP đã hết hạn!');
        }
        if (!Hash::check($otp, $passwordResest->token)) {
            return back()->with('error', 'Mã OTP không hợp lệ!');
        }
        $user->password = Hash::make($password);
        $user->save();
        DB::table('password_reset_tokens')->where('email', $email)->delete();
        return redirect()->route('home');
    }


    // xu li doi mat khau
    public function showFormChangePassWord(){
        return view('client.auth.changePassword');
    }

    public function changePassword(Request $request){
        $request->validate([
            'current_password' => 'required', // mat khau cu
            'new_password' => 'required|min:8|confirmed' // mat khau moi toi thieu 8 ki tu dung voi xac nhan lai
        ],[
        'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
        'current_password.string' => 'Mật khẩu hiện tại phải là chuỗi ký tự.',
        'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
        // 'new_password.string' => 'Mật khẩu mới phải là chuỗi ký tự.',
        'new_password.min' => 'Mật khẩu mới phải có ít nhất 8 ký tự.',
        'new_password.confirmed' => 'Mật khẩu mới và mật khẩu xác nhận không khớp.',
        ]);

        if(!Hash::check($request->current_password,Auth::user()->password)){
            return redirect()->route('showFormChangePassWord')
            ->withErrors(['current_password'=>'Mat khau khong dung'])
            ->withInput();
        }
        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->save();
        return redirect()->route('showFormChangePassWord')->with('success','Mat khau duoc doi thanh cong');
    }


}
