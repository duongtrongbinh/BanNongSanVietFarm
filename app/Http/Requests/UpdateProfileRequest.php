<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Ensure you have the appropriate authorization logic here
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // Retrieve the user model from the route parameters
        $userId = $this->user()->id;

        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$userId,
            'phone' => 'required|unique:users,phone,'.$userId,
            'avatar' => 'nullable|max:2048',
            'address' => 'required',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Tên không được để trống.',
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email đã tồn tại.',
            'phone.required' => 'Số điện thoại không được để trống.',
            'phone.unique' => 'Số điện thoại đã tồn tại.',
            'avatar.max' => 'Dung lượng của avatar không được lớn hơn 2MB.',
            'address.required' => 'Địa chỉ không được để trống.',
        ];
    }
}
