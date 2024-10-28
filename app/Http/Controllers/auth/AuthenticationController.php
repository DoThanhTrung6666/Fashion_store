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
    public function danhmucsp(Request $request)
    {
        // Lấy sản phẩm từ DB
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
                case 'price_below_100':
                    $query->where('price', '<', 100000); // Lọc giá dưới 100.000 VNĐ
                    break;
                case 'price_100_500':
                    $query->whereBetween('price', [100000, 500000]); // Lọc giá từ 100.000 đến 500.000 VNĐ
                    break;
                case 'price_500_1000':
                    $query->whereBetween('price', [500000, 1000000]); // Lọc giá từ 500.000 đến 1.000.000 VNĐ
                    break;
                case 'price_above_1000':
                    $query->where('price', '>', 1000000); // Lọc giá trên 1.000.000 VNĐ
                    break;
                default:
                    $query->latest(); // Mặc định sắp xếp mới nhất
                    break;
            }
        }

        // Lấy sản phẩm với pagination
        $products = $query->paginate(12); // Giả sử mỗi trang có 12 sản phẩm

        return view('client.danhmucsp', compact('products')); // Truyền dữ liệu sản phẩm vào view
    }

    public function showFormRegister(){
        return view('client.auth.register');
    }
    public function register(Request $request){
        User::create([
            'name' => $request->name,
            'email' =>$request->email,
            'password' => Hash::make($request->password),
        ]);
        return view('client.auth.login');
    }
}
