<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        // Retrieve the user model from the route parameters

        return [
            'email' => 'required|email|unique:users,email,'.$this->id.',id',
            'name' => 'required',
            'phone' => 'required|unique:users,phone,'.$this->id.',id',
            'user_code' => 'required|unique:users,user_code,'.$this->id.',id',
            'address' => 'required',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tên không được để trống',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại',
            'phone.required' => 'Số điện thoại không được để trống',
            'phone.unique' => 'Số điện thoại đã tồn tại',
            'address.required' => 'Địa chỉ không được để trống',
            'user_code.required' => 'Mã người dùng không được để trống',
            'user_code.unique' => 'Mã người dùng đã tồn tại',
        ];
    }
}
