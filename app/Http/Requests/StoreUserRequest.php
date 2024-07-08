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
            'name' => 'required|min:4',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'phone' => 'required|unique:users,phone',
            'address' => 'required',
            'avatar' => 'required|max:2048',
            'user_code'=> 'required|unique:users,user_code',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name không được để chống',
            'name.main' => 'Name không được nhỏ hơn 4 ký tự',
            'email.required' => 'email không được để chống',
            'email.email' => 'email không đúng định dạng',
            'email.unique' => 'email đã được tồn tại',
            'password.required' => 'password không được để chống',
            'password.min' => 'password không được nhỏ hơn 8 ký tự',
            'phone.required' => 'phone không được để chống',
            'phone.unique' => 'phone đã được tồn tại',
            'address.required' => 'address không được để chống',
            'user_code.required' => 'user code không được để chống',
            'user_code.unique' => 'user code đã được tồn tại',
            'avatar.required' => 'Vui lòng chọn một hình ảnh.',
            'avatar.max' => 'Hình ảnh không được lớn hơn 2MB.',
        ];
    }
}
