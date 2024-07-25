<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductsImportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_file' => 'required|mimes:xlsx,xls|max:10240',
        ];
    }

    public function messages(): array
    {
        return [
            'product_file.required' => 'Tệp sản phẩm không được để trống.',
            'product_file.mimes' => 'Tệp sản phẩm phải có định dạng: xlsx, xls.',
            'product_file.max' => 'Tệp sản phẩm không được vượt quá 10MB.',
        ];
    }
}
