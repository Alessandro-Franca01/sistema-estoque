<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:products,code',
            'description' => 'nullable|string',
            'meansurement_unit' => 'nullable',
            'custom_meansurement_unit' => 'nullable|string|max:50',
            'observation' => 'nullable|string',
            'is_active' => 'boolean',
            'category_id' => 'required|exists:categories,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'O nome do produto é obrigatório.',
            'name.max' => 'O nome do produto não pode ter mais de 255 caracteres.',
            'code.required' => 'O código do produto é obrigatório.',
            'code.max' => 'O código do produto não pode ter mais de 10 caracteres.',
            'code.unique' => 'Já existe um produto com este código.',
            'meansurement_unit_id.exists' => 'A unidade de medida selecionada não existe.',
            'custom_meansurement_unit.max' => 'A unidade de medida personalizada não pode ter mais de 50 caracteres.',
            'category_id.required' => 'A categoria é obrigatória.',
            'category_id.exists' => 'A categoria selecionada não existe.',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->has('custom_meansurement_unit') && !empty($this->custom_meansurement_unit)) {
            $this->merge([
                'meansurement_unit_id' => null,
            ]);
        } else {
            $this->merge([
                'custom_meansurement_unit' => null,
            ]);
        }
    }
}
