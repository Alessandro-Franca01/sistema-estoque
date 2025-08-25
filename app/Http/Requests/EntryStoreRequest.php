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
            'entry_type' => ['required', 'in:feeding,purchased'],
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'entry_date' => ['required', 'date', 'before_or_equal:today'],
            'observation' => ['nullable', 'string', 'max:255'],
            'invoice_number' => ['required_if:entry_type,purchased', 'string', 'max:30'],
            'contract_number' => ['nullable', 'string', 'max:20'],
            'batch_number' => ['nullable', 'string', 'max:5'],
            'value' => ['required', 'numeric', 'min:0'],
            // Produtos
            'products' => ['required', 'array', 'min:1'],
            'products.*.product_id' => ['required', 'distinct', 'exists:products,id'],
            'products.*.quantity' => ['required', 'integer', 'min:1'],
            'products.*.unit_cost' => ['nullable', 'numeric', 'min:0'],
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
            'supplier_id.required' => 'O fornecedor é obrigatório.',
            'supplier_id.exists' => 'O fornecedor selecionado não é válido.',
            'entry_date.required' => 'A data de entrada é obrigatória.',
            'entry_date.date' => 'A data de entrada deve ser uma data válida.',
            'entry_date.before_or_equal' => 'A data de entrada não pode ser maior que a data atual.',
            'observation.string' => 'A observação deve ser um texto.',
            'observation.max' => 'A observação não pode ter mais de :max caracteres.',
            'invoice_number.required_if' => 'O número da nota fiscal é obrigatório para entradas do tipo compra.',
            'invoice_number.string' => 'O número da nota fiscal deve ser um texto.',
            'invoice_number.max' => 'O número da nota fiscal não pode ter mais de :max caracteres.',
            'contract_number.string' => 'O número do contrato deve ser um texto.',
            'contract_number.max' => 'O número do contrato não pode ter mais de :max caracteres.',
            'batch_number.string' => 'O número do lote deve ser um texto.',
            'batch_number.max' => 'O número do lote não pode ter mais de :max caracteres.',
            'value.required' => 'O valor é obrigatório.',
            'value.numeric' => 'O valor deve ser um número.',
            'value.min' => 'O valor não pode ser negativo.',
            // Produtos
            'products.required' => 'Informe ao menos um produto na alimentação.',
            'products.array' => 'O formato da lista de produtos é inválido.',
            'products.min' => 'Informe ao menos um produto na alimentação.',
            'products.*.product_id.required' => 'O produto é obrigatório.',
            'products.*.product_id.distinct' => 'Cada produto deve ser único na alimentação.',
            'products.*.product_id.exists' => 'O produto selecionado não é válido.',
            'products.*.quantity.required' => 'A quantidade é obrigatória.',
            'products.*.quantity.integer' => 'A quantidade deve ser um número inteiro.',
            'products.*.quantity.min' => 'A quantidade deve ser no mínimo 1.',
            'products.*.unit_cost.numeric' => 'O custo unitário deve ser um número.',
            'products.*.unit_cost.min' => 'O custo unitário não pode ser negativo.',
        ];
    }
}
