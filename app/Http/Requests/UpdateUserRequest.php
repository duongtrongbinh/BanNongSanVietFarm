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
    public function rules(): array
    {
        $userId = $this->route('user')->id; // Lấy ID của user từ route
        return [
            'email' => 'required|email|unique:users,email,'.$userId.',id',
            'name' => 'required',
            'phone' => 'required|unique:users,phone,'.$userId.',id',
            'user_code' => 'required|unique:users,user_code,'.$userId.',id',
            'address' => 'required',
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
            'phone.required' => 'phone không được để chống',
            'phone.unique' => 'phone đã được tồn tại',
            'address.required' => 'address không được để chống',
            'user_code.required' => 'user code không được để chống',
            'user_code.unique' => 'user code đã được tồn tại',
        ];
    }
}
