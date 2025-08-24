@extends('layouts.app')

@section('title', 'Alimentação de Entrada')

@section('content')
    <div class="container mx-auto px-4 py-8 mt-4">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gray-800 text-white px-6 py-4">
                <h1 class="text-2xl font-semibold">Nova Alimentação de Entrada</h1>
            </div>
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="p-6">
                <form action="{{ route('entries.feeding') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <!-- Tipo de Entrada -->
                        <div class="mb-4">
                            <label for="entry_type" class="block text-gray-700 text-sm font-bold mb-2">
                                Tipo de Entrada <span class="text-red-500">*</span>
                            </label>
                            <input type="text" disabled="true" name="type" value="Alimentação"
                                   class="shadow appearance-none bg-gray-400 border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <input type="hidden" name="entry_type" value="feeding">

                        <!-- Fornecedor -->
                        <div class="mb-4">
                            <label for="supplier_id" class="block text-gray-700 text-sm font-bold mb-2">
                                Fornecedor
                            </label>
                            <select name="supplier_id" id="supplier_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('supplier_id') border-red-500 @enderror" required>
                                <option value="">Selecione um fornecedor</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" @selected(old('supplier_id') == $supplier->id)>
                                        {{ $supplier->display_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('supplier_id')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Data de Entrada -->
                        <div class="mb-4">
                            <label for="entry_date" class="block text-gray-700 text-sm font-bold mb-2">
                                Data de Alimentação <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="entry_date" id="entry_date" value="{{ old('entry_date') }}"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('entry_date') border-red-500 @enderror" required>
                            @error('entry_date')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Observação -->
                        <div class="mb-4">
                            <label for="observation" class="block text-gray-700 text-sm font-bold mb-2">
                                Observação
                            </label>
                            <textarea name="observation" id="observation" rows="3"
                                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('observation') }}</textarea>
                        </div>

                        <!-- Número da Nota Fiscal -->
                        <div class="mb-4" id="invoice_field">
                            <label for="invoice_number" class="block text-gray-700 text-sm font-bold mb-2">
                                Número da Nota Fiscal
                            </label>
                            <input type="text" name="invoice_number" id="invoice_number" value="{{ old('invoice_number') }}"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <!-- Número do Contrato -->
                        <div class="mb-4">
                            <label for="contract_number" class="block text-gray-700 text-sm font-bold mb-2">
                                Número do Contrato
                            </label>
                            <input type="text" name="contract_number" id="contract_number" value="{{ old('contract_number') }}"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <!-- Número do Lote (Entrada Geral) -->
                        <div class="mb-4">
                            <label for="batch_number" class="block text-gray-700 text-sm font-bold mb-2">
                                Número do Lote (Entrada Geral)
                            </label>
                            <input type="text" name="batch_number" id="batch_number" value="{{ old('batch_number') }}"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <!-- Valor Total da Entrada -->
                        <div class="mb-4">
                            <label for="value" class="block text-gray-700 text-sm font-bold mb-2">
                                Valor Total da Entrada
                            </label>
                            <input type="number" step="0.01" name="value" id="value" value="{{ old('value') }}"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <h3 class="font-semibold text-lg text-gray-800 leading-tight mt-6 mb-4">Produtos da Entrada</h3>
                        <div id="products-container" class="space-y-4">
                            <!-- Product entry fields will be added here by JavaScript -->
                        </div>
                        <button type="button" id="add-product" class="mt-4 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" onclick="addProductField()">
                            Adicionar Produto
                        </button>
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <button type="submit"
                                class="bg-green-500 hover:bg-green-700 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Cadastrar Alimentação
                        </button>
                        <a href="{{ route('entries.index') }}"
                           class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                            Voltar para a lista
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let productIndex = 0;
            const products = @json($products ?? []); // Garante que products será um array mesmo se $products for null
            // const entryTypeEl = document.getElementById('entry_type');
            // const invoiceFieldEl = document.getElementById('invoice_field');
            // const invoiceInputEl = document.getElementById('invoice_number');
            //
            // function toggleInvoiceRequirement() {
            //     const isPurchased = entryTypeEl.value === 'purchased';
            //     invoiceInputEl.required = isPurchased;
            //     invoiceFieldEl.style.display = isPurchased ? '' : 'none';
            // }
            // entryTypeEl.addEventListener('change', toggleInvoiceRequirement);
            // toggleInvoiceRequirement();

            function addProductField() {
                const container = document.getElementById('products-container');
                const productDiv = document.createElement('div');
                productDiv.classList.add('product-item', 'p-4', 'border', 'rounded-md', 'relative', 'bg-gray-50');
                productDiv.innerHTML = `
                    <button type="button" class="remove-product absolute top-2 right-2 text-red-500 hover:text-red-700 font-bold">×</button>

                    <div class="mb-4">
                        <label for="products_${productIndex}_product_id" class="block text-gray-700 text-sm font-bold mb-2">Produto <span class="text-red-500">*</span></label>
                        <select name="products[${productIndex}][product_id]" id="products_${productIndex}_product_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            <option value="">Selecione um produto</option>
                            ${products.map(product => `<option value="${product.id}">${product.name} (Estoque: ${product.quantity})</option>`).join('')}
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="products_${productIndex}_batch_number" class="block text-gray-700 text-sm font-bold mb-2">Número do Lote (Produto)</label>
                        <input type="text" name="products[${productIndex}][batch_number]" id="products_${productIndex}_batch_number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div class="mb-4">
                        <label for="products_${productIndex}_quantity" class="block text-gray-700 text-sm font-bold mb-2">Quantidade <span class="text-red-500">*</span></label>
                        <input type="number" name="products[${productIndex}][quantity]" id="products_${productIndex}_quantity" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>

                    <div class="mb-4">
                        <label for="products_${productIndex}_unit_cost" class="block text-gray-700 text-sm font-bold mb-2">Custo Unitário <span class="text-red-500">*</span></label>
                        <input type="number" step="0.01" name="products[${productIndex}][unit_cost]" id="products_${productIndex}_unit_cost" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>
                `;
                container.appendChild(productDiv);

                // Adiciona evento de clique para remover o produto
                productDiv.querySelector('.remove-product').addEventListener('click', function() {
                    productDiv.remove();
                });

                productIndex++;
            }

            // Adiciona evento de clique para o botão "Adicionar Produto"
            document.getElementById('add-product').addEventListener('click', addProductField);

            // Adiciona um campo de produto por padrão quando a página carrega
            addProductField();
        });
    </script>

@endsection
