@extends('layouts.app')

@section('title', 'Editar Entrada de Produto')

@section('content')
<div class="container mx-auto px-4 py-8 mt-4">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gray-800 text-white px-6 py-4">
            <h1 class="text-2xl font-semibold">Editar Entrada de Produto #{{ $productEntry->id }}</h1>
        </div>

        <div class="p-6">
            <form action="{{ route('product_entries.update', $productEntry->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Coluna 1 -->
                    <div class="space-y-4">
                        <!-- Produto -->
                        <div>
                            <label for="product_id" class="block text-gray-700 text-sm font-bold mb-2">
                                Produto <span class="text-red-500">*</span>
                            </label>
                            <select name="product_id" id="product_id"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('product_id') border-red-500 @enderror">
                                <option value="">Selecione um produto</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" @selected(old('product_id', $productEntry->product_id) == $product->id)>
                                        {{ $product->name }} ({{ $product->code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Fornecedor -->
                        <div>
                            <label for="supplier_id" class="block text-gray-700 text-sm font-bold mb-2">
                                Fornecedor <span class="text-red-500">*</span>
                            </label>
                            <select name="supplier_id" id="supplier_id"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('supplier_id') border-red-500 @enderror">
                                <option value="">Selecione um fornecedor</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" @selected(old('supplier_id', $productEntry->supplier_id) == $supplier->id)>
                                        {{ $supplier->company_name }} ({{ $supplier->trade_name }})
                                    </option>
                                @endforeach
                            </select>
                            @error('supplier_id')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Quantidade -->
                        <div>
                            <label for="quantity" class="block text-gray-700 text-sm font-bold mb-2">
                                Quantidade <span class="text-red-500">*</span>
                            </label>
                            <input type="number" min="1" name="quantity" id="quantity" value="{{ old('quantity', $productEntry->quantity) }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('quantity') border-red-500 @enderror">
                            @error('quantity')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Custo Unitário -->
                        <div>
                            <label for="unit_cost" class="block text-gray-700 text-sm font-bold mb-2">
                                Custo Unitário <span class="text-red-500">*</span>
                            </label>
                            <input type="number" step="0.01" min="0" name="unit_cost" id="unit_cost" value="{{ old('unit_cost', $productEntry->unit_cost) }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('unit_cost') border-red-500 @enderror">
                            @error('unit_cost')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Coluna 2 -->
                    <div class="space-y-4">
                        <!-- Custo Total (opcional) -->
                        <div>
                            <label for="total_cost" class="block text-gray-700 text-sm font-bold mb-2">
                                Custo Total (opcional)
                            </label>
                            <input type="number" step="0.01" min="0" name="total_cost" id="total_cost" value="{{ old('total_cost', $productEntry->total_cost) }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('total_cost') border-red-500 @enderror">
                            <p class="text-gray-500 text-xs mt-1">Se não preenchido, será calculado automaticamente (quantidade × custo unitário)</p>
                            @error('total_cost')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Número da Nota Fiscal -->
                        <div>
                            <label for="invoice_number" class="block text-gray-700 text-sm font-bold mb-2">
                                Número da Nota Fiscal
                            </label>
                            <input type="text" name="invoice_number" id="invoice_number" value="{{ old('invoice_number', $productEntry->invoice_number) }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('invoice_number') border-red-500 @enderror">
                            @error('invoice_number')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Data de Entrada -->
                        <div>
                            <label for="entry_date" class="block text-gray-700 text-sm font-bold mb-2">
                                Data de Entrada <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="entry_date" id="entry_date" value="{{ old('entry_date', $productEntry->entry_date->format('Y-m-d')) }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('entry_date') border-red-500 @enderror">
                            @error('entry_date')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Observações -->
                        <div>
                            <label for="notes" class="block text-gray-700 text-sm font-bold mb-2">
                                Observações
                            </label>
                            <textarea name="notes" id="notes" rows="3"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('notes', $productEntry->notes) }}</textarea>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center justify-between mt-6">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Atualizar Entrada
                    </button>
                    <a href="{{ route('product_entries.index') }}"
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
        const quantityInput = document.getElementById('quantity');
        const unitCostInput = document.getElementById('unit_cost');
        const totalCostInput = document.getElementById('total_cost');

        // Função para calcular o custo total
        function calculateTotalCost() {
            const quantity = parseFloat(quantityInput.value) || 0;
            const unitCost = parseFloat(unitCostInput.value) || 0;
            
            if (quantity > 0 && unitCost > 0) {
                totalCostInput.value = (quantity * unitCost).toFixed(2);
            }
        }

        // Adicionar event listeners para os inputs
        quantityInput.addEventListener('input', calculateTotalCost);
        unitCostInput.addEventListener('input', calculateTotalCost);
    });
</script>
@endsection