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
        $dbMaxPosotion = ProductCategory::max('position');
        $dbMinPosotion = ProductCategory::min('position');

        $maxPosition = $dbMaxPosotion ? intval($dbMaxPosotion) + 1 : 1;
        $minPosition = $dbMinPosotion ? $dbMinPosotion : 1;

        return [
            'name' => 'required|max:255',
            'parent_id' => 'nullable|exists:product_categories,id',
            'slug' => 'required|max:255',
            'position' => "required|numeric|between:$minPosition,$maxPosition",
            'page_title' => 'nullable|max:255',
            'keywords' => 'nullable|max:255',
            'description' => 'nullable',
            'page_description' => 'nullable',
            'image' => 'nullable',
            'category-property.*.name' => 'required|min:1|max:255|unique:product_category_properties,name',
            'category-property.*.description' => 'required|min:1|max:255',
        ];
    }
}