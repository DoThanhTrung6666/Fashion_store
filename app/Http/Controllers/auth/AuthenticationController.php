<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function danhmucsp(Request $request)
    {
        // Lấy sản phẩm từ DB, bạn có thể thêm các điều kiện lọc ở đây nếu cần
        $query = Product::query();

        // Kiểm tra xem có điều kiện lọc theo giá hay không
        if ($request->has('sort_by')) {
            switch ($request->input('sort_by')) {
                case 2:
                    $query->orderBy('price', 'asc'); // Sắp xếp theo giá thấp đến cao
                    break;
                case 3:
                    $query->orderBy('price', 'desc'); // Sắp xếp theo giá cao đến thấp
                    break;
                    // case 4:
                    //     $query->orderBy('rating', 'desc'); // Sắp xếp theo đánh giá
                    //     break;
                    // case 5:
                    //     $query->orderBy('trending', 'desc'); // Sắp xếp theo độ phổ biến
                    //     break;
                default:
                    $query->latest(); // Mặc định sắp xếp mới nhất
                    break;
            }
        }

        // Lấy sản phẩm với pagination
        $products = $query->paginate(12); // Giả sử mỗi trang có 12 sản phẩm

        return view('client.danhmucsp', compact('products')); // Truyền dữ liệu sản phẩm vào view
    }
}
