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
            'name' => 'required|min:3',
            'email' => 'required|email|min:3',
            'phone' => ['required', 'numeric', 'digits:10'],
            'province' => 'required|not_in:0',
            'district' => 'required|not_in:0',
            'ward' => 'required|not_in:0',
            'note' => 'nullable|string|max:1000',
            'payment_method'=> 'required|in:2,VNPAYQR',
            'specific_address' => 'required|min:3',
            'voucher_id' => 'exists:vouchers,id',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên',
            'name.min' => 'Tên phải có ít nhất :min ký tự',
            'email.email' => 'Địa chỉ email không đúng định dạng',
            'email.min' => 'Địa chỉ email phải có ít nhất :min ký tự',
            'email.required' => 'Vui lòng nhập địa chỉ email',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'phone.numeric' => 'Số điện thoại chỉ được chứa các chữ số',
            'phone.digits' => 'Số điện thoại phải có :digits chữ số',
            'phone.regex' => 'Số điện thoại không đúng định dạng',
            'province.required' => 'Vui lòng chọn tỉnh/thành phố',
            'province.not_in' => 'Vui lòng chọn tỉnh/thành phố',
            'district.required' => 'Vui lòng chọn quận/huyện',
            'district.not_in' => 'Vui lòng chọn quận/huyện',
            'ward.required' => 'Vui lòng chọn phường/xã',
            'ward.not_in' => 'Vui lòng chọn phường/xã',
            'note.string' => 'Ghi chú phải là một chuỗi ký tự',
            'note.max' => 'Ghi chú không được vượt quá :max ký tự',
            'payment_method.required' => 'Vui lòng chọn phương thức thanh toán',
            'payment_method.in' => 'Phương thức thanh toán không hợp lệ',
            'specific_address.required' => 'Vui lòng nhập địa chỉ cụ thể',
            'specific_address.min' => 'Địa chỉ cụ thể phải có ít nhất :min ký tự',
            'voucher_id.exists' => 'Mã giảm giá không tồn tại.',
        ];
    }
}
