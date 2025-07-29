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
}
