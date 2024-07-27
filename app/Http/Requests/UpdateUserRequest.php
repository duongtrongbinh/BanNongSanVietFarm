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
        return true; // Đảm bảo bạn đã thêm logic phân quyền phù hợp ở đây nếu cần
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Lấy ID người dùng từ tham số route
        $userId = $this->route('id'); // Hoặc dùng $this->route('user') nếu tên tham số route của bạn khác

        return [
            'name' => 'required|min:4',
            'email' => 'required|email|unique:users,email,' . $userId,
            'phone' => 'required|unique:users,phone,' . $userId,
            'password' => 'nullable|min:8',
            'address' => 'required',
            'avatar' => 'nullable|max:2048',
            'province_id' => 'required',
            'district_id' => 'required',
            'ward_id' => 'required',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tên không được để trống.',
            'name.min' => 'Tên không được nhỏ hơn 4 ký tự.',
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email đã tồn tại.',
            'phone.required' => 'Số điện thoại không được để trống.',
            'phone.unique' => 'Số điện thoại đã tồn tại.',
            'password.min' => 'Mật khẩu không được nhỏ hơn 8 ký tự.',
            'address.required' => 'Địa chỉ không được để trống.',
            'avatar.max' => 'Hình ảnh không được lớn hơn 2MB.',
            'province_id.required' => 'Tỉnh không được để trống.',
            'district_id.required' => 'Huyện không được để trống.',
            'ward_id.required' => 'Xã không được để trống.',
        ];
    }
}
