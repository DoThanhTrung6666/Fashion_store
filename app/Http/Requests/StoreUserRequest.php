<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:users,name',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'required|numeric|digits_between:10,15',
            'password' => 'required|string|min:8|confirmed', // Cần có trường password_confirmation
            'city' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'zip_code' => 'required|string|max:20',
            'role_id' => 'required|exists:roles,id', // Đảm bảo role tồn tại trong bảng roles
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
