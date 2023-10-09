<?php

namespace App\Http\Requests\AdminPanel;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductReviewRequest extends FormRequest
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
            'product_variant_id' => 'sometimes|required|exists:product_variants,id',
            'rating' => 'sometimes|required|numeric|between:1,5',
            'client_review' => 'sometimes|required|max:65535',
            'client_name' => 'sometimes|required|max:255',
            'visible' => 'sometimes|required|boolean',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'visible' => (boolean) $this->visible,
        ]);
    }
}
