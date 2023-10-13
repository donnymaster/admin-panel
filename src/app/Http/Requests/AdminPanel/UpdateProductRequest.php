<?php

namespace App\Http\Requests\AdminPanel;

use App\Models\AdminPanel\Product;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
        $dbMinPosition = Product::where('category_id', $this->category_id)->min('position_in_category');
        $dbMaxPosition = Product::where('category_id', $this->category_id)->max('position_in_category');

        $maxPosition = $dbMaxPosition ? intval($dbMaxPosition) + 1 : 1;
        $minPosition = $dbMinPosition ? $dbMinPosition : 1;

        return [
            'title' => 'sometimes|required|min:1|max:255',
            'slug' => 'sometimes|required|min:1|max:255',
            'page_title' => 'sometimes|required|min:1|max:255',
            'name_tile' => 'sometimes|required|min:1|max:255',
            'visible' => 'sometimes|required|boolean',
            'position_in_category' => "sometimes|required|numeric|between:$minPosition,$maxPosition",
            'keywords' => 'sometimes|required|min:1|max:255',
            'vendor_code' => 'sometimes|required|min:1|max:255',
            'page_description' => 'sometimes|required|min:1|max:65535',
            'description' => 'sometimes|required|min:1|max:65535',
        ];
    }
}
