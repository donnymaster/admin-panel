<?php

namespace App\Http\Requests\AdminPanel;

use Illuminate\Foundation\Http\FormRequest;

class SettingSiteRequest extends FormRequest
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
            'setting_name' => 'required|min:1|max:255',
            'setting_key' => 'required|min:1|max:255|unique:site_settings,setting_key',
            'setting_value' => 'required|min:1|max:255',
        ];
    }
}
