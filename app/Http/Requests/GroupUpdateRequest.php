<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GroupUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $groupId = $this->route('group');

        return [
            'name' => [
                'required',
                'max:255',
                Rule::unique('groups')->ignore($groupId),
            ],
            'products' => 'required|array',
            'products.*' => 'integer|exists:products,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên nhóm không được để trống.',
            'name.unique' => 'Tên nhóm đã tồn tại.',
            'name.max' => 'Tên nhóm không được vượt quá 255 ký tự.',
            'products.required' => 'Danh sách sản phẩm không được để trống.',
            'products.array' => 'Danh sách sản phẩm phải là một mảng.',
            'products.*.integer' => 'Mã sản phẩm phải là số nguyên.',
            'products.*.exists' => 'Sản phẩm không tồn tại.',
        ];
    }
}
