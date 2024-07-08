<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'brand_id' => 'required|exists:App\Models\Brand,id',
            'category_id' => 'required|exists:App\Models\Category,id',
            'name' => 'required|unique:products,name|max:255',
            'image.*' => 'required',
            'price_regular' => 'required|numeric|min:1',
            'price_sale' => 'required|numeric|min:1|lt:price_regular',
            'quantity' => 'required|numeric|min:1',
            'length' => 'integer|required|min:1|max:200',
            'width' => 'integer|required|min:1|max:200',
            'height' => 'integer|required|min:1|max:200',
            'weight' => 'integer|required|min:1|max:1600000',
            'tags' => 'required|array',
            'tags.*' => 'integer|exists:tags,id',
            'products' => 'required|array',
            'products.*' => 'integer|exists:App\Models\Product,id',
        ];
    }

    public function messages(): array
    {
        return [
            'brand_id.required' => 'Thương hiệu không được để trống.',
            'brand_id.exists' => 'Thương hiệu không tồn tại.',
            'category_id.required' => 'Danh mục không được để trống.',
            'category_id.exists' => 'Danh mục không tồn tại.',
            'name.required' => 'Tên sản phẩm không được để trống.',
            'name.unique' => 'Tên sản phẩm đã tồn tại.',
            'name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự.',
            'image.*.required' => 'Hình ảnh không được để trống.',
            'price_regular.required' => 'Giá thường không được để trống.',
            'price_regular.numeric' => 'Giá thường phải là số.',
            'price_regular.min' => 'Giá thường phải lớn hơn hoặc bằng 1.',
            'price_sale.required' => 'Giá khuyến mãi không được để trống.',
            'price_sale.numeric' => 'Giá khuyến mãi phải là số.',
            'price_sale.min' => 'Giá khuyến mãi phải lớn hơn hoặc bằng 1.',
            'price_sale.lt' => 'Giá khuyến mãi phải nhỏ hơn giá thường.',
            'quantity.required' => 'Số lượng không được để trống.',
            'quantity.numeric' => 'Số lượng phải là số.',
            'quantity.min' => 'Số lượng phải lớn hơn hoặc bằng 1.',
            'length.integer' => 'Chiều dài phải là số nguyên.',
            'length.required' => 'Chiều dài không được để trống.',
            'length.min' => 'Chiều dài phải lớn hơn hoặc bằng 1.',
            'length.max' => 'Chiều dài không được vượt quá 200.',
            'width.integer' => 'Chiều rộng phải là số nguyên.',
            'width.required' => 'Chiều rộng không được để trống.',
            'width.min' => 'Chiều rộng phải lớn hơn hoặc bằng 1.',
            'width.max' => 'Chiều rộng không được vượt quá 200.',
            'height.integer' => 'Chiều cao phải là số nguyên.',
            'height.required' => 'Chiều cao không được để trống.',
            'height.min' => 'Chiều cao phải lớn hơn hoặc bằng 1.',
            'height.max' => 'Chiều cao không được vượt quá 200.',
            'weight.integer' => 'Trọng lượng phải là số nguyên.',
            'weight.required' => 'Trọng lượng không được để trống.',
            'weight.min' => 'Trọng lượng phải lớn hơn hoặc bằng 1.',
            'weight.max' => 'Trọng lượng không được vượt quá 1600000.',
            'tags.required' => 'Nhãn không được để trống.',
            'tags.array' => 'Nhãn phải là một mảng.',
            'tags.*.integer' => 'Mã nhãn phải là số nguyên.',
            'tags.*.exists' => 'Nhãn không tồn tại.',
            'products.required' => 'Danh sách sản phẩm không được để trống.',
            'products.array' => 'Mã danh sách sản phẩm phải là một mảng.',
            'products.*.integer' => 'Mã sản phẩm phải là số nguyên.',
            'products.*.exists' => 'Sản phẩm không tồn tại.',
        ];
    }
}