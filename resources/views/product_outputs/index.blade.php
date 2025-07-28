@extends('layouts.app')

@section('title', 'Registrar Nova Saída de Produto')

@section('content')
<div class="container mx-auto px-4 py-8 mt-4">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gray-800 text-white px-6 py-4">
            <h1 class="text-2xl font-semibold">Registrar Nova Saída de Produto</h1>
        </div>

        <div class="p-6">
            <form action="{{ route('product_outputs.store') }}" method="POST">
                @csrf

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
                                    <option value="{{ $product->id }}" @selected(old('product_id', $selectedProductId ?? null) == $product->id) data-stock="{{ $product->stock_quantity }}">
                                        {{ $product->name }} (Estoque: {{ $product->stock_quantity }})
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Cliente/Destino -->
                        <div>
                            <label for="client_id" class="block text-gray-700 text-sm font-bold mb-2">
                                Cliente/Destino <span class="text-red-500">*</span>
                            </label>
                            <select name="client_id" id="client_id"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('client_id') border-red-500 @enderror">
                                <option value="">Selecione um cliente/destino</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}" @selected(old('client_id') == $client->id)>
                                        {{ $client->name }} ({{ $client->document }})
                                    </option>
                                @endforeach
                            </select>
                            @error('client_id')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Quantidade -->
                        <div>
                            <label for="quantity" class="block text-gray-700 text-sm font-bold mb-2">
                                Quantidade <span class="text-red-500">*</span>
                            </label>
                            <input type="number" min="1" name="quantity" id="quantity" value="{{ old('quantity', 1) }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('quantity') border-red-500 @enderror">
                            <p id="stock-warning" class="text-red-500 text-xs italic mt-1 hidden">Quantidade superior ao estoque disponível!</p>
                            @error('quantity')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Preço de Venda Unitário -->
                        <div>
                            <label for="unit_price" class="block text-gray-700 text-sm font-bold mb-2">
                                Preço de Venda Unitário
                            </label>
                            <input type="number" step="0.01" min="0" name="unit_price" id="unit_price" value="{{ old('unit_price') }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('unit_price') border-red-500 @enderror">
                            @error('unit_price')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Coluna 2 -->
                    <div class="space-y-4">
                        <!-- Valor Total (opcional) -->
                        <div>
                            <label for="total_price" class="block text-gray-700 text-sm font-bold mb-2">
                                Valor Total (opcional)
                            </label>
                            <input type="number" step="0.01" min="0" name="total_price" id="total_price" value="{{ old('total_price') }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('total_price') border-red-500 @enderror">
                            <p class="text-gray-500 text-xs mt-1">Se não preenchido, será calculado automaticamente (quantidade × preço unitário)</p>
                            @error('total_price')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Número do Documento -->
                        <div>
                            <label for="document_number" class="block text-gray-700 text-sm font-bold mb-2">
                                Número do Documento
                            </label>
                            <input type="text" name="document_number" id="document_number" value="{{ old('document_number') }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('document_number') border-red-500 @enderror">
                            @error('document_number')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Data de Saída -->
                        <div>
                            <label for="output_date" class="block text-gray-700 text-sm font-bold mb-2">
                                Data de Saída <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="output_date" id="output_date" value="{{ old('output_date', date('Y-m-d')) }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('output_date') border-red-500 @enderror">
                            @error('output_date')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Observações -->
                        <div>
                            <label for="notes" class="block text-gray-700 text-sm font-bold mb-2">
                                Observações
                            </label>
                            <textarea name="notes" id="notes" rows="3"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center justify-between mt-6">
                    <button type="submit" id="submit-btn"
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Registrar Saída
                    </button>
                    <a href="{{ route('product_outputs.index') }}"
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
        const productSelect = document.getElementById('product_id');
        const quantityInput = document.getElementById('quantity');
        const unitPriceInput = document.getElementById('unit_price');
        const totalPriceInput = document.getElementById('total_price');
        const stockWarning = document.getElementById('stock-warning');
        const submitBtn = document.getElementById('submit-btn');

        // Função para verificar estoque
        function checkStock() {
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            const stock = selectedOption ? parseInt(selectedOption.getAttribute('data-stock')) : 0;
            const quantity = parseInt(quantityInput.value) || 0;
            
            if (quantity > stock) {
                stockWarning.classList.remove('hidden');
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                stockWarning.classList.add('hidden');
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }

        // Função para calcular o valor total
        function calculateTotalPrice() {
            const quantity = parseFloat(quantityInput.value) || 0;
            const unitPrice = parseFloat(unitPriceInput.value) || 0;
            
            if (quantity > 0 && unitPrice > 0) {
                totalPriceInput.value = (quantity * unitPrice).toFixed(2);
            }
        }

        // Adicionar event listeners
        productSelect.addEventListener('change', checkStock);
        quantityInput.addEventListener('input', function() {
            checkStock();
            calculateTotalPrice();
        });
        unitPriceInput.addEventListener('input', calculateTotalPrice);
        
        // Verificar estoque inicial
        checkStock();
    });
</script>
@endsection