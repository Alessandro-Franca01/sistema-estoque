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
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'sku' => 'nullable|string|max:255|unique:products,sku',
            'stock_quantity' => 'required|integer|min:0',
            'manage_stock' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gallery' => 'nullable|array',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'weight' => 'nullable|numeric|min:0',
            'length' => 'nullable|numeric|min:0',
            'width' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
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
            'slug.unique' => 'Já existe um produto com este slug.',
            'slug.max' => 'O slug não pode ter mais de 255 caracteres.',
            'price.required' => 'O preço é obrigatório.',
            'price.numeric' => 'O preço deve ser um número.',
            'price.min' => 'O preço deve ser maior ou igual a zero.',
            'sale_price.numeric' => 'O preço promocional deve ser um número.',
            'sale_price.min' => 'O preço promocional deve ser maior ou igual a zero.',
            'sale_price.lt' => 'O preço promocional deve ser menor que o preço normal.',
            'sku.unique' => 'Já existe um produto com este SKU.',
            'sku.max' => 'O SKU não pode ter mais de 255 caracteres.',
            'stock_quantity.required' => 'A quantidade em estoque é obrigatória.',
            'stock_quantity.integer' => 'A quantidade em estoque deve ser um número inteiro.',
            'stock_quantity.min' => 'A quantidade em estoque deve ser maior ou igual a zero.',
            'image.image' => 'O arquivo deve ser uma imagem.',
            'image.mimes' => 'A imagem deve ser do tipo: jpeg, png, jpg, gif, svg.',
            'image.max' => 'A imagem não pode ser maior que 2MB.',
            'gallery.array' => 'A galeria deve ser um array de imagens.',
            'gallery.*.image' => 'Cada arquivo da galeria deve ser uma imagem.',
            'gallery.*.mimes' => 'As imagens da galeria devem ser do tipo: jpeg, png, jpg, gif, svg.',
            'gallery.*.max' => 'Cada imagem da galeria não pode ser maior que 2MB.',
            'weight.numeric' => 'O peso deve ser um número.',
            'weight.min' => 'O peso deve ser maior ou igual a zero.',
            'length.numeric' => 'O comprimento deve ser um número.',
            'length.min' => 'O comprimento deve ser maior ou igual a zero.',
            'width.numeric' => 'A largura deve ser um número.',
            'width.min' => 'A largura deve ser maior ou igual a zero.',
            'height.numeric' => 'A altura deve ser um número.',
            'height.min' => 'A altura deve ser maior ou igual a zero.',
            'category_id.required' => 'A categoria é obrigatória.',
            'category_id.exists' => 'A categoria selecionada não existe.',
        ];
    }
}