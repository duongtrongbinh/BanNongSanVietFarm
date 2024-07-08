<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $tagId = $this->route('tag')->id;

        return [
            'name' => 'required|unique:tags,name,' . $tagId . '|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên nhãn không được để trống.',
            'name.unique' => 'Tên nhãn đã tồn tại.',
            'name.max' => 'Tên nhãn không được vượt quá 255 ký tự.',
        ];
    }
}
