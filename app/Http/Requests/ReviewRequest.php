<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
    public function rules()
    {
        return [
            'rating' => ['required', 'numeric', 'between:1,5'], 
            'review' => ['required', 'max:120'],
        ];
    }

    public function messages()
    {
        return [
            'rating.required' => 'Vui lòng đánh giá sản phẩm.',
            'rating.numeric' => 'Đánh giá phải là một số.',
            'rating.between' => 'Đánh giá phải nằm trong khoảng từ 1 đến 5 và bắt buộc.',
            'review.required' => 'Vui lòng viết nhận xét của bạn.',
            'review.max' => 'Nhận xét không được vượt quá :max ký tự.',
        ];
    }
}
