<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
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
        $productId = $this->route('product')->id;

        return [
            'name' => 'required|string|max:255',
            'code' => ['nullable', 'string', 'max:10', Rule::unique('products', 'code')->ignore($productId)],
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
            'observation' => 'nullable|string',
            'is_active' => 'boolean',
            'category_id' => 'required|exists:categories,id',
            'measurement_types_id' => 'nullable|exists:measurement_types,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome do produto é obrigatório.',
            'name.max' => 'O nome do produto não pode ter mais de 255 caracteres.',
            'code.unique' => 'Já existe um produto com este código.',
            'code.max' => 'O código do produto não pode ter mais de 10 caracteres.',
            'quantity.required' => 'A quantidade é obrigatória.',
            'quantity.integer' => 'A quantidade deve ser um número inteiro.',
            'quantity.min' => 'A quantidade não pode ser menor que 0.',
            'category_id.required' => 'A categoria é obrigatória.',
            'category_id.exists' => 'A categoria selecionada não existe.',
            'measurement_types_id.exists' => 'O tipo de medida selecionado não existe.',
        ];
    }
}