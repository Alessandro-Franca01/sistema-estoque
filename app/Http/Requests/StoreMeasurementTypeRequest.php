<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMeasurementTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'acronym' => 'required|string|max:20',
            'description' => 'nullable|string',
            'used_measurement' => 'nullable|numeric',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'acronym.required' => 'A sigla é obrigatória.',
        ];
    }
} 