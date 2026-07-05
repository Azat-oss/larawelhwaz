<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|min:5|unique:categories'
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'Название категории должно быть уникальным.',
            'name.required' => 'Название категории к заполнению обязательна.',
        ];
    }
}
