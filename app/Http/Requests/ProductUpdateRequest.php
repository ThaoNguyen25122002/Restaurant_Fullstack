<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
        // dd($this->product->id);
        return [
            'product_name' => ['required', 'max:100', 'unique:products,product_name,'.$this->product->id],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['required', 'max:250'],
            'price' => ['required', 'numeric'],
            // 'in_stock' => ['required'],
            'newImage' => ['nullable', 'image', 'mimes:jpg,png,gif,svg,webp', 'max:2048'],
            'quantity' => ['required', 'integer','min:1'],
            'set_quantity' => ['required', 'integer','min:1'],

        ];
    }

    public function messages(): array
    {
        return [
            'product_name.required' => 'Tên sản phẩm là bắt buộc.',
            'product_name.max' => 'Tên sản phẩm không được vượt quá 100 ký tự.',
            'product_name.unique' => 'Tên sản phẩm đã tồn tại.',
            'category_id.required' => 'Danh mục là bắt buộc.',
            'category_id.exists' => 'Danh mục không hợp lệ.',
            'description.required' => 'Mô tả là bắt buộc.',
            'description.max' => 'Mô tả không được vượt quá 250 ký tự.',
            'price.required' => 'Giá là bắt buộc.',
            'price.numeric' => 'Giá phải là một số.',
            'in_stock.required' => 'Tình trạng kho là bắt buộc.',
            'newImage.image' => 'Tệp phải là hình ảnh.',
            'newImage.mimes' => 'Hình ảnh phải có định dạng: jpg, png, gif, svg, webp.',
            'newImage.max' => 'Hình ảnh không được vượt quá 2048KB.',
            'quantity.required' => 'Số lượng là bắt buộc.',
            'quantity.integer' => 'Số lượng phải là một số nguyên.',
            'quantity.min' => 'Nhập ít nhất :min số.',
            'set_quantity.required' => 'Số lượng được mặt định được set là bắt buộc.',
            'set_quantity.integer' => 'Số lượng được mặt định được set phải là một số nguyên.',
            'set_quantity.min' => 'Nhập ít nhật :min số.',
        ];
    }
}
