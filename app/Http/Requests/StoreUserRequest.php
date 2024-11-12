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
}
