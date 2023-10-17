<?php

namespace App\Http\Requests\AdminPanel;

use App\Models\AdminPanel\ProductVariant;
use Illuminate\Foundation\Http\FormRequest;

class AddVariantInOrderRequest extends FormRequest
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
        $variant = ProductVariant::where('id', $this->variant_id)->firstOrFail();

        $maxProductVariant = $variant->count;

        return [
            'variant_id' => 'required|exists:product_variants,id',
        ];
    }
}
