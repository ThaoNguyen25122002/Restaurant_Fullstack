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
            'category_id' => ['required', 'exists:roles,id'],
            'description' => ['required', 'max:250'],
            'price' => ['required', 'numeric'],
            'in_stock' => ['required'],
            'newImage' => ['nullable', 'image', 'mimes:jpg,png,gif,svg,webp', 'max:2048']
        ];
    }
}
