<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next): Response
    // {

    //     if(Auth::user()->role_id==1){
    //         return $next($request);
    //     }
    //     return redirect('/home');
        
    // }

    public function handle(Request $request, Closure $next): Response
{
    // Kiểm tra xem người dùng hiện tại có role_id bằng 1 hay không
    // if(Auth::user()->role_id == 1){
    //     return $next($request); // Nếu đúng, tiếp tục xử lý yêu cầu
    // }
    // Nếu không phải là admin, chuyển hướng về trang home
    return $next($request); // Luôn cho phép truy cập
}

}
