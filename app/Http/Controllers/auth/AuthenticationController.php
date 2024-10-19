<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    //
    public function showFormLogin(){
        return view('client.auth.login');
    }

    public function login(Request $request){
        $login = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if(Auth::attempt($login)){
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
}
