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
    public function messages(): array
    {
        return [
            'name.required' => 'Tên không được để chống!',
            'email.required'=> 'email không được để chống!',
            'email.email'   => 'email không đúng định dạng!',
            'email.unique'  => 'email đã được tồn tại!',
            'password.required' => 'password không được để chống!',
            'password.min'  => 'password không được nhỏ hơn 8 ký tự'
        ];
    }
}
