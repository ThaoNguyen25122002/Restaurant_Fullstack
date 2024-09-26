<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
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
            'category_name' => ['required', 'unique:categories,category_name'],
            'category_image' => ['required', 'image', 'mimes:jpg,png,gif,svg,webp', 'max:2048'],
            'is_show' => ['required', 'integer'],
            'sort' => ['nullable', 'integer'],
        ];
    }
    public function messages(): array
    {
        return [
            'category_name.required' => 'Tên danh mục là bắt buộc.',
            'category_name.unique' => 'Tên danh mục đã tồn tại.',
            'category_image.required' => 'Hình ảnh danh mục là bắt buộc.',
            'category_image.image' => 'Hình ảnh danh mục phải là một tệp hình ảnh.',
            'category_image.mimes' => 'Hình ảnh danh mục phải có định dạng: jpg, png, gif, svg, webp.',
            'category_image.max' => 'Hình ảnh danh mục không được vượt quá 2MB.',
            'is_show.required' => 'Trạng thái hiển thị là bắt buộc.',
            'is_show.integer' => 'Trạng thái hiển thị phải là một số nguyên.',
            'sort.integer' => 'Mức độ ưu tiên phải là một số nguyên.',
        ];
    }
}
