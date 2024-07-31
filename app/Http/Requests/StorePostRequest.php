<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            'title'=> 'required',
            'description'=> 'required',
            'content'=> 'required',
            'image' => 'required|nullable'
        ];
    }
    public function messages()
    {
        return [
            'title.required'=> 'Tiêu không được để chống',
            'description.required'  => 'Miêu tả không được để chống',
            'content.required'      => 'Nôi dung không được để chống',
            'image.required' => 'Hình ảnh không được để chống! ',
        ];
    }
}
