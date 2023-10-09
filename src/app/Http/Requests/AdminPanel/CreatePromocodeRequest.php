<?php

namespace App\Http\Requests\AdminPanel;

use Illuminate\Foundation\Http\FormRequest;

class CreatePromocodeRequest extends FormRequest
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
            'name' => 'required|max:255',
            'status' => 'required|boolean',
            'code' => 'required|max:255|unique:promocodes,code',
            'quantity' => 'required|numeric',
            'percentages' => 'required|numeric',
            'product_variant_id' => 'sometimes|required|exists:product_variants,id',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'status' => (boolean) $this->status,
        ]);
    }
}
