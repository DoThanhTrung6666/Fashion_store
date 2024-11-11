<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $validatedData = $request->validated();

        // Tạo người dùng mới
        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->phone = $validatedData['phone'];
        $user->password = bcrypt($validatedData['password']); // Băm mật khẩu
        $user->city = $validatedData['city'];
        $user->address = $validatedData['address'];
        $user->zip_code = $validatedData['zip_code'];
        $user->role_id = $validatedData['role_id']; // Gán role_id từ form
        $user->save();

        // Chuyển hướng sau khi lưu thành công
        return redirect()->route('admin.users.index')->with('success', 'Người dùng đã được tạo thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $model = User::findOrFail($id); // Sử dụng findOrFail để lấy đối tượng người dùng

        // Truyền dữ liệu vào view
        $roles = Role::all(); // Lấy tất cả các vai trò
        return view('admin.users.update', compact('model', 'roles')); // Truyền cả model và roles vào view
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        // Tìm người dùng
        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->city = $request->input('city');
        $user->address = $request->input('address');
        $user->zip_code = $request->input('zip_code');

        // Cập nhật password nếu có
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->role_id = $request->input('role_id');
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Cập nhật người dùng thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        // Xóa người dùng
        $user->delete();

        // Thêm thông báo thành công vào session
        return redirect()->route('admin.users.index')->with('success', 'Người dùng đã được xóa thành công!');
    }
}
