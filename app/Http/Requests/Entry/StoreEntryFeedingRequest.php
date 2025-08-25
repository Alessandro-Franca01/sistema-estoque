<?php

namespace App\Http\Requests\Entry;

use Illuminate\Foundation\Http\FormRequest;

class StoreEntryFeedingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Altere para false se precisar de lógica de autorização
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'entry_type' => ['required', 'in:feeding'],
            'entry_date' => ['required', 'date'],
            'observation' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'entry_type.required' => 'O tipo de entrada é obrigatório.',
            'entry_type.in' => 'O tipo de entrada selecionado é inválido.',
            'entry_date.required' => 'A data de entrada é obrigatória.',
            'entry_date.date' => 'A data de entrada deve ser uma data válida.',
            'observation.string' => 'A observação deve ser um texto.',
            'observation.max' => 'A observação não pode ter mais de :max caracteres.',
        ];
    }
}
