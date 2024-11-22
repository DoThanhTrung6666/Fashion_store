<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'email' => 'required',
            'otp' => 'required',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'otp.required' => 'OTP không được để trống',
            'password.required' => 'Mật khẩu không được để trống',
            'password.confirmed'=> 'Mật khẩu phải trùng với xác nhận mật khẩu',
            'password.min' => 'Mật khẩu không được nhỏ hơn 6 ký tự',
            'password_confirmation.required' => 'Xác nhận mật khẩu không được để trống',
        ];
    }
}
