<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ];
    }

    /**
     * Get the custom validation messages for the request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tên của bạn không được để trống!',
            'email.required'=> 'Email của bạn không được để trống!',
            'email.email'   => 'Email của bạn không đúng định dạng!',
            'email.unique'  => 'Email của bạn đã được sử dụng!',
            'password.required' => 'Mật khẩu của bạn không được để trống!',
            'password.min'  => 'Mật khẩu của bạn không được nhỏ hơn 8 ký tự',
        ];
    }
}
