@extends('layouts.app')

@section('title', 'Registrar Nova Saída')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Cabeçalho -->
        <div class="bg-gray-800 text-white px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-semibold">Registrar Nova Saída</h1>
            <a href="{{ route('outputs.index') }}" class="text-sm text-gray-300 hover:text-white">
                ← Voltar para lista
            </a>
        </div>

        <!-- Corpo do Formulário -->
        <div class="p-6">
            <form action="{{ route('outputs.store') }}" method="POST">
                @csrf

                <!-- Seção de Informações Básicas -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Informações da Saída</h2>
                    <div class="grid grid-cols-1 md:grid-cols-1">
                        <!-- Data da Saída -->
                        <div>
                            <label for="output_date" class="block text-sm font-medium text-gray-700 mb-1">Data da Saída <span class="text-red-500">*</span></label>
                            <input type="datetime-local" name="output_date" id="output_date"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 px-3 border"
                                   required>
                        </div>

                        <!-- Funcionário Responsável -->
                        <div class="md:col-span-2 mt-2">
                            <label for="public_servant_id" class="block text-sm font-medium text-gray-700 mb-1">Funcionário Responsável <span class="text-red-500">*</span></label>
                            <select name="public_servant_id" id="public_servant_id"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 px-3 border"
                                    required>
                                @foreach ($public_servants as $servant)
                                    <option value="{{ $servant->id }}">{{ $servant->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Seção de Observação -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Observações</h2>
                    <div>
                        <label for="observation" class="block text-sm font-medium text-gray-700 mb-1">Observações Adicionais</label>
                        <textarea name="observation" id="observation" rows="3"
                                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 px-3 border"></textarea>
                    </div>
                </div>

                <!-- Seção de Produtos -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Produtos</h2>
                    <div id="products-container" class="space-y-4">
                        <!-- Primeiro produto (obrigatório) -->
                        <div class="product-entry bg-gray-50 p-4 rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Seleção de Produto -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Produto <span class="text-red-500">*</span></label>
                                    <select name="products[0][product_id]"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 px-3 border"
                                            required>
                                        @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }} (Estoque: {{ $product->quantity }})</option>
                                @endforeach
                                    </select>
                                </div>

                                <!-- Quantidade -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Quantidade <span class="text-red-500">*</span></label>
                                    <input type="number" name="products[0][quantity]"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 px-3 border"
                                           min="1" value="1" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botão para adicionar mais produtos -->
                    <button type="button" id="add-product"
                            class="mt-4 inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Adicionar Produto
                    </button>
                </div>

                <!-- Botão de Submissão -->
                <div class="flex justify-end">
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Registrar Saída
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addProductBtn = document.getElementById('add-product');
        const productsContainer = document.getElementById('products-container');

        // Adicionar novo produto
        addProductBtn.addEventListener('click', function() {
            const index = productsContainer.children.length;
            const newEntry = document.createElement('div');
            newEntry.classList.add('product-entry', 'bg-gray-50', 'p-4', 'rounded-lg');

            newEntry.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Produto <span class="text-red-500">*</span></label>
                        <select name="products[${index}][product_id]"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 px-3 border"
                                required>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }} (Estoque: {{ $product->quantity }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Quantidade <span class="text-red-500">*</span></label>
                        <input type="number" name="products[${index}][quantity]"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 px-3 border"
                               min="1" value="1" required>
                        <button type="button" class="remove-product mt-2 text-xs text-red-600 hover:text-red-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Remover
                        </button>
                    </div>
                </div>
            `;

            productsContainer.appendChild(newEntry);

            // Adiciona evento para remover o produto
            newEntry.querySelector('.remove-product').addEventListener('click', function() {
                newEntry.remove();
            });
        });
    });
</script>
@endsection
