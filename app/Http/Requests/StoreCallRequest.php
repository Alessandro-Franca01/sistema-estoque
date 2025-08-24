<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCallRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'type' => 'required|string|max:255',
            'service_order' => 'nullable|string|max:255',
            'connect_code' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'applicant' => 'nullable|string|max:255',
            'destination' => 'required|string',
            'cep' => 'nullable|string|max:8',
            'complement' => 'nullable|string',
            'observation' => 'nullable|string',
            'output_id' => 'nullable|exists:outputs,id',
        ];
    }
}
