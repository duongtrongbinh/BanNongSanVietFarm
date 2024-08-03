<?php

namespace App\Http\Requests;
use App\Rules\AfterNow;
use Barryvdh\Debugbar\Twig\Extension\Debug;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class VoucherRequest extends FormRequest
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
            $rules = [
              'title' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('vouchers')->where(function ($query) {
                        return $query->where('start_date', $this->input('start_date'))
                            ->where('end_date', $this->input('end_date'));
                    }),
              ],
            'quantity' => 'required|integer|min:1',
            'amount' => [
                Rule::when($this->input('type_unit') == 0, [
                    'required',
                    'numeric',
                    'min:1000',
                ]),
                Rule::when($this->input('type_unit') == 1, [
                    'integer',
                    'max:99',
                    'min:1',
                ])
            ],
            'start_date' => [
                Rule::when(!$this->input('infinite'), [
                    'required',
                    'date',
                    'date_format:Y-m-d\TH:i',
                    new AfterNow()
                ],null)
            ],
            'end_date' => [
                Rule::when(!$this->input('infinite'), [
                    'required',
                    'date',
                    'date_format:Y-m-d\TH:i',
                    'after:start_date'
                ], null)
            ],
            'description' => 'nullable|string',
            'is_active' => [
                Rule::when($this->has('active'),1, 0)
            ],
            'type_unit' => 'required|integer|in:0,1', // Ensure type_unit is provided and is either 0 or 1
            'code' => 'required',
        ];
        if ($this->isMethod('patch') || $this->isMethod('put')) {
            $rules['title'] = [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('vouchers')->where(function ($query) {
                    return $query->where('start_date', $this->input('start_date'))
                        ->where('end_date', $this->input('end_date'));
                        // Bỏ qua kiểm tra unique cho mục hiện tại khi cập nhật
                })->ignore($this->input('id')),
            ];
            $rules['quantity'] = 'sometimes|required|integer|min:1';
            $rules['amount'] = [
                Rule::when($this->input('type_unit') == 0, [
                    'sometimes',
                    'required',
                    'numeric',
                    'min:1000',
                ]),
                Rule::when($this->input('type_unit') == 1, [
                    'sometimes',
                    'integer',
                    'max:99',
                    'min:1',
                ])
            ];
            $rules['start_date'] = [
                'sometimes',
                Rule::when(!$this->input('infinite'), [
                    'required',
                    'date',
                    'date_format:Y-m-d\TH:i',
                    new AfterNow()
                ], 'nullable')
            ];
            $rules['end_date'] = [
                'sometimes',
                Rule::when(!$this->input('infinite'), [
                    'required',
                    'date',
                    'date_format:Y-m-d\TH:i',
                    'after:start_date'
                ], 'nullable')
            ];
            $rules['is_active'] = [
                'sometimes',
                Rule::when($this->has('active'), 1, 0)
            ];
            $rules['type_unit'] = 'sometimes|required|integer|in:0,1'; // Ensure type_unit is sometimes required and is either 0 or 1
        }
        return $rules;
    }

    protected function prepareForValidation()
    {

        if ($this->input('infinite')) {
            $this->merge([
                'start_date' => null,
                'end_date' => null,
            ]);
        }
        if ($this->has('is_active')) {
            $this->merge([
                'is_active' => 1,
            ]);
        }else{
            $this->merge([
                'is_active' => 0,
            ]);
        }
    }
}
