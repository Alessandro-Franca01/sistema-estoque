<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $supplierId = $this->route('supplier')->id ?? null;
        return [
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:14',
            'active' => 'boolean',
            'observation' => 'nullable|string',
        ];
    }

    /**
     * Mensagens de validação personalizadas.
     */
    public function messages(): array
    {
        return [
            'email.email' => 'Informe um :attribute válido.',
            'email.max' => 'O :attribute não pode ter mais que :max caracteres.',

            'phone.max' => 'O :attribute não pode ter mais que :max caracteres.',

            'active.boolean' => 'O campo :attribute é inválido.',

            'observation.string' => 'O campo :attribute deve ser um texto válido.',
        ];
    }

    /**
     * Nomes amigáveis dos atributos.
     */
    public function attributes(): array
    {
        return [
            'legal_name' => 'Razão Social',
            'trade_name' => 'Nome Fantasia',
            'cnpj' => 'CNPJ',
            'state_registration' => 'Inscrição Estadual',
            'municipal_registration' => 'Inscrição Municipal',
            'email' => 'E-mail',
            'phone' => 'Telefone',
            'active' => 'status',
            'observation' => 'Observações',
        ];
    }
}
