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
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('products', 'slug')->ignore($productId),
            ],
            'description' => 'nullable|string',
            'meansurement_unit' => 'nullable|string|max:50',
            'observation' => 'nullable|string',
            'is_active' => 'boolean',
            'category_id' => 'required|exists:categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome do produto é obrigatório.',
            'name.max' => 'O nome do produto não pode ter mais de 255 caracteres.',
            'slug.unique' => 'Já existe um produto com este slug.',
            'slug.max' => 'O slug não pode ter mais de 255 caracteres.',
            'description.max' => 'A descrição não pode ter mais de 255 caracteres.',
            'meansurement_unit.max' => 'A unidade de medida não pode ter mais de 50 caracteres.',
            'observation.max' => 'A observação não pode ter mais de 255 caracteres.',
        ];
    }
}