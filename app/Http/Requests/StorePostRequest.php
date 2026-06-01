<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|min:2|max:255',
            'body' => 'required|string|min:5|max:1000',
        ];
    }

    // custom messages for validation errors

    public function messages(): array
    {
        return [
            'title.required' => 'The title is required, you forgetful potato.',
            'title.string' => 'The title must be a string.',
            'title.min' => 'The title must be at least :min characters.',
            'title.max' => 'The title may not be greater than :max characters.',
            'body.required' => 'The body is required.',
            'body.string' => 'The body must be a string.',
            'body.min' => 'The body must be at least :min characters.',
            'body.max' => 'The body may not be greater than :max characters.',
        ];
    }
}
