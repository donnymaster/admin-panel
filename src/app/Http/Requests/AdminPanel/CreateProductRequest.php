<?php

namespace App\Http\Requests\AdminPanel;

use App\Models\AdminPanel\Product;
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
        $dbMinPosition = Product::where('category_id', $this->category_id)->min('position_in_category');
        $dbMaxPosition = Product::where('category_id', $this->category_id)->max('position_in_category');

        $maxPosition = $dbMaxPosition ? intval($dbMaxPosition) + 1 : 1;
        $minPosition = $dbMinPosition ? $dbMinPosition : 1;

        return [
            'name' => 'required|min:1|max:255|unique:products,name',
            'category_id' => 'required|numeric|exists:product_categories,id',
            'slug' => 'required|min:1|max:255',
            'page_title' => 'required|min:1|max:255',
            'name_tile' => 'required|min:1|max:255',
            'visible' => 'sometimes|required|boolean',
            'position_in_category' => "required|numeric|between:$minPosition,$maxPosition",
            'keywords' => 'required|min:1|max:255',
            'vendor_code' => 'required|min:1|max:255|unique:products,vendor_code',
            'page_description' => 'required|min:1|max:65535',
            'description' => 'required|min:1|max:65535',

            'product-unique-property.*' => 'sometimes|required|array',
            'product-unique-property.*.name' => 'required|min:1|max:255',
            'product-unique-property.*.value' => 'required|min:1|max:255',

        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'visible' => (boolean) $this->visible,
        ]);
    }
}
