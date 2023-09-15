<?php

namespace App\Http\Requests\AdminPanel;

use Illuminate\Foundation\Http\FormRequest;

class CreatePageRequest extends FormRequest
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
            'name' => 'required|min:1|max:255',
            'route' => 'required|min:1|max:255',
            'title' => 'required|min:1|max:255',
            'description' => 'nullable|min:1|max:65535',
            'keywords' => 'nullable|min:1|max:255',
            'old_route' => 'nullable|min:1|max:255',
            'canonical_address' => 'nullable|min:1|max:255',
            'page_description' => 'nullable|min:1|max:16777215',
            'og_title' => 'nullable|min:1|max:255',
            'og_type' => 'nullable|min:1|max:255',
            'og_url' => 'nullable|min:1|max:255',
            'og_image' => 'nullable|file',
            'og_description' => 'nullable|min:1|max:255',
            'og_site_name' => 'nullable|min:1|max:255',
            'og_vk_image' => 'nullable|file',
            'og_fb_image' => 'nullable|file',
            'og_twitter_image' => 'nullable|file',
            'is_show' => 'nullable|boolean',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_show' => (boolean) $this->is_show,
        ]);
    }
}
