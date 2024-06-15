<?php

namespace App\Http\Requests;

use App\Models\Supplier;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SupplierUpdateRequest extends FormRequest
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
        $suppplierId = $this->supplier->id;
        return [
            'name' => [
                'required',
                'string',
                Rule::unique('suppliers', 'name')->ignore($suppplierId)->whereNull('deleted_at'),
                'max:255'
            ],
            'company' => 'required|string|max:255',
            'tax_code' => 'required|string|max:255',
            'contact_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone_number' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'note' => 'nullable|string',
        ];
    }
}