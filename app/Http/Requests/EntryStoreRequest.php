<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EntryStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
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
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'entry_date' => ['required', 'date'],
            'observation' => ['nullable', 'string', 'max:255'],
            'is_existing' => ['boolean'],
            'invoice_number' => ['nullable', 'string', 'max:30'],
            'contract_number' => ['nullable', 'string', 'max:20'],
            'batch_number' => ['nullable', 'string', 'max:10'],
            'value' => ['required', 'numeric', 'min:0'],
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
            'supplier_id.required' => 'O fornecedor é obrigatório.',
            'supplier_id.exists' => 'O fornecedor selecionado não é válido.',
            'entry_date.required' => 'A data de entrada é obrigatória.',
            'entry_date.date' => 'A data de entrada deve ser uma data válida.',
            'observation.string' => 'A observação deve ser um texto.',
            'observation.max' => 'A observação não pode ter mais de :max caracteres.',
            'is_existing.boolean' => 'O campo "existente" deve ser verdadeiro ou falso.',
            'invoice_number.string' => 'O número da nota fiscal deve ser um texto.',
            'invoice_number.max' => 'O número da nota fiscal não pode ter mais de :max caracteres.',
            'contract_number.string' => 'O número do contrato deve ser um texto.',
            'contract_number.max' => 'O número do contrato não pode ter mais de :max caracteres.',
            'batch_number.string' => 'O número do lote deve ser um texto.',
            'batch_number.max' => 'O número do lote não pode ter mais de :max caracteres.',
            'value.required' => 'O valor é obrigatório.',
            'value.numeric' => 'O valor deve ser um número.',
            'value.min' => 'O valor não pode ser negativo.',
        ];
    }
}
