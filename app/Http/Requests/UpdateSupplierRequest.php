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
            'legal_name' => 'required|string|max:255',
            'trade_name' => 'nullable|string|max:255',
            'cnpj' => [
                'required',
                'string',
                'size:14',
                Rule::unique('suppliers', 'cnpj')->ignore($supplierId),
            ],
            'state_registration' => 'nullable|string|max:9',
            'municipal_registration' => 'nullable|string|max:7',
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
            'legal_name.required' => 'A :attribute é obrigatória.',
            'legal_name.max' => 'A :attribute não pode ter mais que :max caracteres.',

            'trade_name.max' => 'O :attribute não pode ter mais que :max caracteres.',

            'cnpj.required' => 'O :attribute é obrigatório.',
            'cnpj.size' => 'O :attribute deve conter exatamente :size dígitos (somente números).',
            'cnpj.unique' => 'O :attribute informado já está cadastrado.',

            'state_registration.max' => 'A :attribute deve ter no máximo :max caracteres.',
            'municipal_registration.max' => 'A :attribute deve ter no máximo :max caracteres.',

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
