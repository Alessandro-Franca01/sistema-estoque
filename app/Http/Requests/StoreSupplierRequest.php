<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'legal_name' => 'required|string|max:255',
            'trade_name' => 'nullable|string|max:255',
            'cnpj' => 'required|string|size:14|unique:suppliers,cnpj',
            'state_registration' => 'nullable|string|max:9',
            'municipal_registration' => 'nullable|string|max:7',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:14',
            'active' => 'boolean',
            'observation' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'legal_name.required' => 'O nome legal é obrigatório.',
            'legal_name.string' => 'O nome legal deve ser um texto.',
            'legal_name.max' => 'O nome legal não pode ter mais de 255 caracteres.',

            'trade_name.string' => 'O nome fantasia deve ser um texto.',
            'trade_name.max' => 'O nome fantasia não pode ter mais de 255 caracteres.',

            'cnpj.required' => 'O CNPJ é obrigatório.',
            'cnpj.string' => 'O CNPJ deve ser um texto.',
            'cnpj.size' => 'O CNPJ deve ter exatamente 14 caracteres.',
            'cnpj.unique' => 'Este CNPJ já está cadastrado.',

            'state_registration.string' => 'A inscrição estadual deve ser um texto.',
            'state_registration.max' => 'A inscrição estadual não pode ter mais de 9 caracteres.',

            'municipal_registration.string' => 'A inscrição municipal deve ser um texto.',
            'municipal_registration.max' => 'A inscrição municipal não pode ter mais de 7 caracteres.',

            'email.email' => 'O e-mail deve ser um endereço válido.',
            'email.max' => 'O e-mail não pode ter mais de 255 caracteres.',

            'phone.string' => 'O telefone deve ser um texto.',
            'phone.max' => 'O telefone não pode ter mais de 14 caracteres.',

            'active.boolean' => 'O campo ativo deve ser verdadeiro ou falso.',

            'observation.string' => 'A observação deve ser um texto.'
        ];
    }
}
