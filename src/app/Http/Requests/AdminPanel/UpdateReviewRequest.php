<?php

namespace App\Http\Requests\AdminPanel;

use App\Models\AdminPanel\Review;
use Illuminate\Foundation\Http\FormRequest;

class UpdateReviewRequest extends FormRequest
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
        $maxPosition = Review::max('position');
        $minPosition = Review::min('position');

        return [
            'position' => "nullable|numeric|between:$minPosition,$maxPosition",
            'is_show' => 'nullable|boolean',
        ];
    }
}
