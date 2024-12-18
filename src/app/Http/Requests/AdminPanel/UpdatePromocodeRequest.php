<?php

namespace App\Http\Requests\AdminPanel;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePromocodeRequest extends FormRequest
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
            'name' => 'sometimes|required|max:255',
            'status' => 'sometimes|required|boolean',
            'quantity' => 'sometimes|required|numeric',
            'percentages' => 'sometimes|required|numeric',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'status' => (boolean) $this->status,
        ]);
    }
}
