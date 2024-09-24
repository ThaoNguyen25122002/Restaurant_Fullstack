<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'email'=>['required','max:100','email','unique:users,email'],
            'name'=>['required','max:60'],
            'password'=> ['required','min:6','confirmed'],
            "phone" => ['nullable','min:10'],
            "address" => ['nullable','max:100']
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.max' => 'Địa chỉ email không được vượt quá :max ký tự.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.unique' => 'Email này đã tồn tại trong hệ thống.',
            'name.required' => 'Vui lòng nhập địa chỉ email.',
            'name.max' => 'Tên được sử dụng tối đa là :max ký tự.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
            'password.confirmed' => 'Mật khẩu không khớp.',
            'phone.min' => 'Số điện thoái có ít nhất :min ký tự.',
            'address.max' => 'Địa chỉ được sử dụng tối đa là :max ký tự.'
        ];
    }
}
