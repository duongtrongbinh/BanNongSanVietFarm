<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBannerRequest extends FormRequest
{
    /**
     * Xác thực xem người dùng có quyền gửi yêu cầu này không.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Xác thực dữ liệu đầu vào.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'image' => 'required|max:2048',
        ];
    }

    /**
     * Tùy chỉnh thông báo lỗi.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Tiêu đề không được để chống.',
            'title.string' => 'Tiêu đề phải là chuỗi văn bản.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'image.required' => 'Ảnh là bắt buộc.',
            'image.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',
        ];
    }
}
