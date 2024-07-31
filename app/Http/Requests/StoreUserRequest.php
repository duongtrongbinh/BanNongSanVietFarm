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
            'province_id' => 'required',
            'district_id' => 'required',
            'ward_id' => 'required',
            'user_code'=> 'required|unique:users,user_code',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Tên không được để trống',
            'name.min' => 'Tên không được nhỏ hơn 4 ký tự',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu không được nhỏ hơn 8 ký tự',
            'phone.required' => 'Số điện thoại không được để trống',
            'phone.unique' => 'Số điện thoại đã tồn tại',
            'address.required' => 'Địa chỉ không được để trống',
            'avatar.required' => 'Vui lòng chọn ảnh đại diện.',
            'avatar.max' => 'Hình ảnh đã vượt 2MB.',
            'province_id.required' => 'Tỉnh không được để trống',
            'district_id.required' => 'Huyện không được để trống',
            'ward_id.required' => 'Xã không được để trống',
        ];
    }
}
