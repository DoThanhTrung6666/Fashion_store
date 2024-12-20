<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules() :array
    {
        $userId = $this->route('user'); // Lấy ID của người dùng hiện tại từ route

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $userId,
            'phone' => 'required|string|max:255',
            'password' => 'nullable|string|min:6|confirmed', // Đặt password là optional
            'city' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'zip_code' => 'required|string|max:255',
            'role_id' => 'required|exists:roles,id',
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'Email này đã được sử dụng.',
                'name.required' => 'Tên là trường bắt buộc.',
                'name.max' => 'Tên không được vượt quá :max ký tự.',
                'email.required' => 'Email là trường bắt buộc.',
                'email.email' => 'Email không đúng định dạng.',
                'email.unique' => 'Email này đã được sử dụng.',
                'phone.required' => 'Số điện thoại là trường bắt buộc.',
                'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
                'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
                'city.required' => 'Thành phố là trường bắt buộc.',
                'address.required' => 'Địa chỉ là trường bắt buộc.',
                'zip_code.required' => 'Mã bưu điện là trường bắt buộc.',
                'role_id.required' => 'Vai trò là trường bắt buộc.',
                'role_id.exists' => 'Vai trò không hợp lệ.',
        ];
    }
}
