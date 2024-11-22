<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Mail\mailPassword;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Nette\Utils\Random;

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
        ]);

        if (Auth::attempt($login)) {
            $request->session()->regenerate();

            // /**
            //  * @var User $user
            //  */
            // $user = Auth::user();
            // if($user->isAdmin()){
            //     return redirect()->route('home');
            // }
            return redirect()->route('home');
        }
        return redirect('/home');
    }
    // public function danhmucsp()
    // {
    //     return view('client.danhmucsp'); // Đảm bảo rằng view tồn tại
    // }


    public function showFormRegister()
    {
        return view('client.auth.register');
    }
    public function register(Request $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 2,
        ]);
        return view('client.auth.login');
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
}
