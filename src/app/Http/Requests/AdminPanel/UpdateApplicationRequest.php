<?php

namespace App\Http\Requests\AdminPanel;

use Illuminate\Foundation\Http\FormRequest;

class UpdateApplicationRequest extends FormRequest
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
            'full_name_client' => 'nullable|string|min:1|max:255',
            'phone_client' => 'nullable|string|min:1|max:255',
            'additional_information' => 'nullable|string|min:1|max:255',
            'processed' => 'nullable|boolean',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'processed' => (boolean) $this->processed,
        ]);
    }
}
