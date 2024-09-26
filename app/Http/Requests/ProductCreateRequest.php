<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductCreateRequest extends FormRequest
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
            'product_name' => ['required', 'max:100', 'unique:products,product_name'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['required', 'max:250'],
            'price' => ['required', 'numeric'],
            'in_stock' => ['required'],
            'image_url' => ['image', 'mimes:jpg,png,gif,svg,webp', 'max:2048']
        ];
    }
    public function messages()
    {
        return [
            'product_name.required' => 'Tên sản phẩm là bắt buộc.',
            'product_name.max' => 'Tên sản phẩm không được vượt quá :max ký tự.',
            'product_name.unique' => 'Tên sản phẩm đã tồn tại.',
            'category_id.required' => 'Danh mục là bắt buộc.',
            'category_id.exists' => 'Danh mục không hợp lệ.',
            'description.required' => 'Mô tả là bắt buộc.',
            'description.max' => 'Mô tả không được vượt quá :max ký tự.',
            'price.required' => 'Giá là bắt buộc.',
            'price.numeric' => 'Giá phải là một số.',
            'in_stock.required' => 'Trạng thái là bắt buộc.',
            'image_url.image' => 'Tệp phải là một hình ảnh.',
            'image_url.mimes' => 'Hình ảnh phải có định dạng: jpg, png, gif, svg, webp.',
            'image_url.max' => 'Hình ảnh không được vượt quá 2048 KB.'
        ];
    }
}
