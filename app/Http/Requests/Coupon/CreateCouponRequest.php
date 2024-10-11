<?php

namespace App\Http\Requests\Coupon;

use Illuminate\Foundation\Http\FormRequest;

class CreateCouponRequest extends FormRequest
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
            'code' => ['required','unique:coupons,code'],
            'discount_percentage' => ['required', 'numeric', 'between:1,100'],
            'quantity' => ['required', 'numeric'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
        ];
    }
    public function messages()
    {
        return [
            'code.required' => 'Vui lòng nhập code của mã giảm giá.',
            'code.unique' => 'Code của mã giảm giá đã tồn tại.',
            'discount_percentage.required' => 'Vui lòng nhập % của mã giảm giá.',
            'discount_percentage.numeric' => '% giảm giá phải là số nguyên.',
            'discount_percentage.between' => 'Giới hạn trong khoảng 1 -> 100.',
            'quantity.required' => 'Vui lòng số lượng.',
            'quantity.numeric' => 'Định dạng số lượng không phù hợp.',
            'start_date.required' => 'Vui lòng nhập ngày bắt đầu.',
            'start_date.date' => 'Sai định dạng.',
            'end_date.required' => 'Vui lòng nhập ngày kết thúc.',
            'end_date.date' => 'Sai định dạng.',
        ];
    }

}
