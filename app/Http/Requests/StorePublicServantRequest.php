<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePublicServantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'registration' => 'required|string|max:9|unique:public_servants,registration',
            'cpf' => 'nullable|string|size:11',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'job_function' => 'required|in:OPERADOR,ALMOXARIFE,SERVIDOR,ADMINISTRADOR',
            'position' => 'nullable|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'outsourced_company' => 'nullable|string|max:255',
            'servant_type' => 'required|in:EFETIVO,COMISSIONADO,TERCEIRIZADO',
        ];
    }
}
