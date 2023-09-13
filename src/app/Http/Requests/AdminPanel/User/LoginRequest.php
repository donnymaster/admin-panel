<?php

namespace App\Http\Requests\AdminPanel\User;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'required|max:255|email',
            'password' => 'nullable|required|min:6|max:255',
            'remember' => 'nullable|boolean',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'remember' => (boolean) $this->remember,
        ]);
    }
}
