<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    public function login()
    {
        return view('client.logins.login');
    }

   // login
    public function userLogin(Request $request)
    {
        $data = $request->only(['username', 'password']);
        // Kiem tra tai khoan co trong CSDL khongo
        if (Auth::attempt($data)) {
            return redirect()->route('home');
        } else {
            return redirect()->back()->with('errorLogin', 'username 
            hoac password khong chinh xac');
        }
    }
    
    public function register()
    {
        return view('client.logins.register');
    }

    // Register
    public function userRegister(Request $request){
        $data = $request->all();
        User::query()->create($data);
        return redirect()->route('login')->with('message', 'Đăng ký tài khoản thành công');

    }
 // logout
    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
}
