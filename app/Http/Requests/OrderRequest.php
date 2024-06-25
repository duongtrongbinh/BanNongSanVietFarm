<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'voucher_id' => 'nullable|integer|exists:vouchers,id',
            'name' => 'required|min:3',
            'email' => 'required|min:3',
            'address' => 'required|min:5',
            'phone' => 'required|numeric',
            'province' => 'required|exists:provinces,id',
            'note' => 'nullable|string|max:1000',
            'payment_method'=> 'required'
        ];
    }
}