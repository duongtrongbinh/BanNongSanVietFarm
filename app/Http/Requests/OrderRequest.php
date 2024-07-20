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
            'specific_address' => 'required|min:5',
            'phone' => ['required', 'regex:/^(0[3|5|7|8|9])+([0-9]{8})$/'],
            'province' => 'required',
            'district' => 'required',
            'ward' => 'required',
            'note' => 'nullable|string|max:1000',
            'payment_method'=> 'required'
        ];
    }
}
