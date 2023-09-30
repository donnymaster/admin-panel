<?php

namespace App\Http\Requests\AdminPanel;

use App\Models\AdminPanel\ProductCategory;
use Illuminate\Foundation\Http\FormRequest;

class CreateProductCategoryRequest extends FormRequest
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
        $maxPosition = intval(ProductCategory::max('position')) + 1;
        $minPosition = ProductCategory::min('position');

        return [
            'name' => 'required|max:255',
            'parent_id' => 'nullable|numeric|exists:product_categories,id',
            'slug' => 'required|max:255',
            'position' => "numeric|between:$minPosition,$maxPosition",
            'page_title' => 'nullable|max:255',
            'keywords' => 'nullable|max:255',
            'description' => 'nullable',
            'page_description' => 'nullable',
            'image' => 'nullable',
            'category-property.*.name' => 'required|min:1|max:255',
            'category-property.*.description' => 'required|min:1|max:255',

        ];
    }
}
