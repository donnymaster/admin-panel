<?php

namespace App\Http\Requests\AdminPanel;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:1|max:255|unique:products,name',
            'category_id' => 'required|numeric|exists:product_categories,id',
            'slug' => 'required|min:1|max:255',
            'page_title' => 'required|min:1|max:255',
            'name_tile' => 'required|min:1|max:255',
            'visible' => 'required|boolean',
            'keywords' => 'required|min:1|max:255',
            'vendor_code' => 'required|min:1|max:255|unique:products:vendor_code',
            'page_description' => 'required|min:1|max:65535',
            'description' => 'required|min:1|max:65535',

            'product-unique-property.*' => 'sometimes|required|array',
            'product-unique-property.*.name' => 'required|min:1|max:255',
            'product-unique-property.*.value' => 'required|min:1|max:255',

        ];
    }
}
