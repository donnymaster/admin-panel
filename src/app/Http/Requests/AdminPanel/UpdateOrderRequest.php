<?php

namespace App\Http\Requests\AdminPanel;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
        return [
            'client_name' => 'sometimes|required|min:1|max:255',
            'phone_number' => 'sometimes|required|min:1|max:255',
            'total_quantity' => 'sometimes|numeric',
            'delivery_address' => 'sometimes|required|min:1|max:255',
            'type_delivery' => 'sometimes|required|min:1|max:255',
            'user_annotation' => 'nullable|min:1|max:65535',
            'admin_annotation' => 'nullable|min:1|max:65535',
        ];
    }
}
