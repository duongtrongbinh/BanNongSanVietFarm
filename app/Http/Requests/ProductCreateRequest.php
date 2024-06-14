<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductCreateRequest extends FormRequest
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
            'brand_id' => 'required',
            'category_id' => 'required',
            'name' => 'required|max:255',
            'image' => 'required',
            'excerpt' => 'required',
            'price_regular' => 'required|numeric',
            'price_sale' => 'required|numeric|lt:price_regular',
            'quantity' => 'required',
            'tag' => 'required|array',
            'tag*' => 'integer|exists:tags,id'
        ];
    }

    // Define custom error messages
    public function messages(): array
    {
        return [
            'price_sale.lt' => 'The sale price must be less than the regular price.',
        ];
    }
}
