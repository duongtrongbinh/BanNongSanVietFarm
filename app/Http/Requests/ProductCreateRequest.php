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
            'brand_id' => 'requiredexists:App\Models\Brand,id',
            'category_id' => 'requiredexists:App\Models\Category,id',
            'name' => 'required|unique:products,name|max:255',
            'image' => 'required',
            'price_regular' => 'required|numeric',
            'price_sale' => 'required|numeric|lt:price_regular',
            'quantity' => 'required',
            'length' => 'integer|required|max:200',
            'width' => 'integer|required|max:200',
            'height' => 'integer|required|max:200',
            'weight' => 'integer|required|max:1600000',
            'tags' => 'array',
            'tags*' => 'integer|requiredexists:App\Models\Tag,id',
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