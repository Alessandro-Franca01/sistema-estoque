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
            'company_name' => 'required|string|max:255',
            'trade_name' => 'nullable|string|max:255',
            'cnpj' => 'required|string|size:14|unique:suppliers,cnpj',
            'state_registration' => 'nullable|string|max:255',
            'municipal_registration' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'active' => 'boolean',
            'notes' => 'nullable|string',
        ];
    }
} 