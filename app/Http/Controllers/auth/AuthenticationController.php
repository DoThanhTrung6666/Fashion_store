<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
}
