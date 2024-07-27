<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
        // Lấy ID bài viết từ tham số route
        $postId = $this->route('id');

        return [
            'title' => 'required',
            'description' => 'required',
            'content' => 'required',
            'image' => 'nullable|image|max:2048',
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
            'title.required' => 'Tiêu đề không được để trống.',
            'description.required' => 'Miêu tả không được để trống.',
            'content.required' => 'Nội dung không được để trống.',
            'image.image' => 'Hình ảnh không hợp lệ.',
            'image.max' => 'Hình ảnh không được lớn hơn 2MB.',
        ];
    }
}
