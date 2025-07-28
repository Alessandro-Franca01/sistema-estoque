@extends('layouts.app')

@section('title', 'Registrar Nova Saída de Produto')

@section('content')
    <div class="container mx-auto px-4 py-8 mt-4">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gray-800 text-white px-6 py-4">
                <h1 class="text-2xl font-semibold">Registrar Baixa de Saida/Produto</h1>
            </div>

            <div class="p-6">
                <form action="#" method="POST">
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
                                    <option value="">Refletor 15v</option>
                                    <option value="">Lampada led 10w</option>
                                    <option value="">Poste 12m</option>
                                </select>
                            </div>

                            <!-- Saida -->
                            <div>
                                <label for="client_id" class="block text-gray-700 text-sm font-bold mb-2">
                                    Saida <span class="text-red-500">*</span>
                                </label>
                                <select name="client_id" id="client_id"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('client_id') border-red-500 @enderror">
                                    <option value="">Selecione uma Saida</option>
                                    <option value="1">Saida 01</option>
                                    <option value="2">Saida 02</option>
                                    <option value="3">Saidal 03</option>
                                    <option value="4">Saida 04</option>
                                    <option value="5">Saida 05</option>
                                </select>
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
                        </div>

                        <!-- Coluna 2 -->
                        <div class="space-y-4">

                            <!-- Data de Saída -->
                            <div>
                                <label for="output_date" class="block text-gray-700 text-sm font-bold mb-2">
                                    Data de Baixa <span class="text-red-500">*</span>
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
                        <a href="#"
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
