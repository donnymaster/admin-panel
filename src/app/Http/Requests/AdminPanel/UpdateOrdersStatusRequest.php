<?php

namespace App\Http\Requests\AdminPanel;

use App\Services\AdminPanel\OrderService;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrdersStatusRequest extends FormRequest
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
        $validStatuses = OrderService::STATUS_ORDER_IN_PROCESSING.','.OrderService::STATUS_ORDER_NEW.','.OrderService::STATUS_ORDER_PROCESSED;

        return [
            'orders_id' => 'required|array',
            'orders_id.*' => 'required|exists:orders,id',
            'type' => "required|in:$validStatuses",
        ];
    }
}
