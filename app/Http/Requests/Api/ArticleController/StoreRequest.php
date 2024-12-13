<?php

namespace App\Http\Requests\Api\ArticleController;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'title' => 'required|string',
            'author' => 'required|string',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'source' => 'nullable|string',
            'url' => 'nullable|string',
            'categories' => 'nullable|string',
            'keywords' => 'nullable|string',
            'published_at' => 'nullable|date',
            // 'user_id' => 'nullable',
        ];
    }
}
