@extends('layouts.app')

@section('title', 'Editar Entrada')

@section('content')
    @php
        $user = auth()->user();
        $canEdit = $user?->hasAnyRole(['administrativo', 'almoxarife']);
    @endphp

    <div class="container mx-auto px-4 py-8 mt-4">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gray-800 text-white px-6 py-4">
                <h1 class="text-2xl font-semibold">Editar Entrada #{{ $entry->id }}</h1>
            </div>

            <div class="p-6">
                <form method="POST" action="{{ route('entries.update', $entry) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Coluna 1 -->
                        <div class="space-y-4">
                            <!-- Entry Type -->
                            <div>
                                <x-input-label for="entry_type" :value="__('Tipo de Entrada')" />
                                <select id="entry_type" name="entry_type" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="">Selecione o tipo</option>
                                    <option value="purchased" {{ old('entry_type', $entry->entry_type) === 'purchased' ? 'selected' : '' }}>Compra</option>
                                    <option value="feeding" {{ old('entry_type', $entry->entry_type) === 'feeding' ? 'selected' : '' }}>Alimentação</option>
                                    <option value="reversal" {{ old('entry_type', $entry->entry_type) === 'reversal' ? 'selected' : '' }}>Estorno</option>
                                </select>
                                <x-input-error :messages="$errors->get('entry_type')" class="mt-2" />
                            </div>

                            <!-- Supplier -->
                            <div>
                                <x-input-label for="supplier_id" :value="__('Fornecedor')" />
                                <select id="supplier_id" name="supplier_id" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="">Selecione um fornecedor</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" {{ old('supplier_id', $entry->supplier_id) == $supplier->id ? 'selected' : '' }}>{{ $supplier->trade_name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('supplier_id')" class="mt-2" />
                            </div>

                            <!-- Entry Date -->
                            <div>
                                <x-input-label for="entry_date" :value="__('Data de Entrada')" />
                                <x-text-input id="entry_date" class="block mt-1 w-full" type="date" name="entry_date" :value="old('entry_date', $entry->entry_date->format('Y-m-d'))" required />
                                <x-input-error :messages="$errors->get('entry_date')" class="mt-2" />
                            </div>

                            <!-- Invoice Number -->
                            <div id="invoice_field">
                                <x-input-label for="invoice_number" :value="__('Número da Nota Fiscal')" />
                                <x-text-input id="invoice_number" class="block mt-1 w-full" type="text" name="invoice_number" :value="old('invoice_number', $entry->invoice_number)" />
                                <x-input-error :messages="$errors->get('invoice_number')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Coluna 2 -->
                        <div class="space-y-4">
                            <!-- Contract Number -->
                            <div>
                                <x-input-label for="contract_number" :value="__('Número do Contrato')" />
                                <x-text-input id="contract_number" class="block mt-1 w-full" type="text" name="contract_number" :value="old('contract_number', $entry->contract_number)" />
                                <x-input-error :messages="$errors->get('contract_number')" class="mt-2" />
                            </div>

                            <!-- Batch Number -->
                            <div>
                                <x-input-label for="batch_number" :value="__('Número do Lote (Entrada Geral)')" />
                                <x-text-input id="batch_number" class="block mt-1 w-full" type="text" name="batch_number" :value="old('batch_number', $entry->batch_number)" />
                                <x-input-error :messages="$errors->get('batch_number')" class="mt-2" />
                            </div>

                            <!-- Value -->
                            <div>
                                <x-input-label for="value" :value="__('Valor Total da Entrada')" />
                                <x-text-input id="value" class="block mt-1 w-full" type="number" step="0.01" name="value" :value="old('value', $entry->value)" />
                                <x-input-error :messages="$errors->get('value')" class="mt-2" />
                            </div>

                            <!-- Is Existing -->
                            <div class="flex items-center">
                                <input type="checkbox" id="is_existing" name="is_existing" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" {{ old('is_existing', $entry->is_existing) ? 'checked' : '' }}>
                                <x-input-label for="is_existing" class="inline ml-2" :value="__('É Existente?')" />
                                <x-input-error :messages="$errors->get('is_existing')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Observation -->
                    <div class="mt-6">
                        <x-input-label for="observation" :value="__('Observação')" />
                        <textarea id="observation" name="observation" rows="3" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('observation', $entry->observation) }}</textarea>
                        <x-input-error :messages="$errors->get('observation')" class="mt-2" />
                    </div>

                    <!-- Products Section -->
                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Produtos da Entrada</h3>

                        <div id="products-container" class="mt-4 space-y-4">
                            @foreach ($entry->products as $index => $product)
                                <div class="product-item p-4 border rounded-md relative bg-gray-50">
                                    <button type="button" class="remove-product absolute top-2 right-2 text-red-500 hover:text-red-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <!-- Product -->
                                        <div>
                                            <x-input-label for="products_{{ $index }}_product_id" :value="__('Produto')" />
                                            <select name="products[{{ $index }}][product_id]" id="products_{{ $index }}_product_id" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                                <option value="">Selecione um produto</option>
                                                @foreach ($products as $p)
                                                    <option value="{{ $p->id }}" {{ old("products.{$index}.product_id", $product->id) == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                                                @endforeach
                                            </select>
                                            <x-input-error :messages="$errors->get('products.'.$index.'.product_id')" class="mt-2" />
                                        </div>

                                        <!-- Batch Item -->
                                        <div>
                                            <x-input-label for="products_{{ $index }}_batch_item" :value="__('Número do Lote (Produto)')" />
                                            <x-text-input id="products_{{ $index }}_batch_item" class="block mt-1 w-full" type="text" name="products[{{ $index }}][batch_item]" :value="old('products.'.$index.'.batch_item', $product->pivot->batch_item)" />
                                            <x-input-error :messages="$errors->get('products.'.$index.'.batch_item')" class="mt-2" />
                                        </div>

                                        <!-- Quantity -->
                                        <div>
                                            <x-input-label for="products_{{ $index }}_quantity" :value="__('Quantidade')" />
                                            <x-text-input id="products_{{ $index }}_quantity" class="block mt-1 w-full" type="number" name="products[{{ $index }}][quantity]" :value="old('products.'.$index.'.quantity', $product->pivot->quantity)" required />
                                            <x-input-error :messages="$errors->get('products.'.$index.'.quantity')" class="mt-2" />
                                        </div>

                                        <!-- Unit Cost -->
                                        <div>
                                            <x-input-label for="products_{{ $index }}_unit_cost" :value="__('Custo Unitário')" />
                                            <x-text-input id="products_{{ $index }}_unit_cost" class="block mt-1 w-full" type="number" step="0.01" name="products[{{ $index }}][unit_cost]" :value="old('products.'.$index.'.unit_cost', $product->pivot->unit_cost)" required />
                                            <x-input-error :messages="$errors->get('products.'.$index.'.unit_cost')" class="mt-2" />
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if($canEdit)
                            <button type="button" id="add-product" class="mt-4 inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Adicionar Produto
                            </button>
                        @endif
                    </div>

                    <div class="flex items-center justify-end mt-8">
                        <a href="{{ route('entries.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-2">
                            Cancelar
                        </a>
                        <x-primary-button>
                            {{ __('Atualizar Entrada') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Toggle invoice field based on entry type
            const entryTypeEl = document.getElementById('entry_type');
            const invoiceFieldEl = document.getElementById('invoice_field');
            const invoiceInputEl = document.getElementById('invoice_number');

            function toggleInvoiceRequirement() {
                const isPurchased = entryTypeEl.value === 'purchased';
                if (invoiceInputEl) invoiceInputEl.required = isPurchased;
                if (invoiceFieldEl) invoiceFieldEl.style.display = isPurchased ? 'block' : 'none';
            }

            if (entryTypeEl) {
                toggleInvoiceRequirement();
                entryTypeEl.addEventListener('change', toggleInvoiceRequirement);
            }

            // Product management
            let productIndex = {{ count($entry->products) }};
            const products = @json($products);

            function addProductField() {
                const container = document.getElementById('products-container');
                const productDiv = document.createElement('div');
                productDiv.classList.add('product-item', 'p-4', 'border', 'rounded-md', 'relative', 'bg-gray-50', 'mt-4');

                productDiv.innerHTML = `
                    <button type="button" class="remove-product absolute top-2 right-2 text-red-500 hover:text-red-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Product -->
                        <div>
                            <label for="products_${productIndex}_product_id" class="block text-sm font-medium text-gray-700">Produto</label>
                            <select name="products[${productIndex}][product_id]" id="products_${productIndex}_product_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">Selecione um produto</option>
                                ${products.map(product => `<option value="${product.id}">${product.name}</option>`).join('')}
                            </select>
                        </div>

                        <!-- Batch Item -->
                        <div>
                            <label for="products_${productIndex}_batch_item" class="block text-sm font-medium text-gray-700">Número do Lote (Produto)</label>
                            <input type="text" id="products_${productIndex}_batch_item" name="products[${productIndex}][batch_item]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Quantity -->
                        <div>
                            <label for="products_${productIndex}_quantity" class="block text-sm font-medium text-gray-700">Quantidade</label>
                            <input type="number" id="products_${productIndex}_quantity" name="products[${productIndex}][quantity]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>

                        <!-- Unit Cost -->
                        <div>
                            <label for="products_${productIndex}_unit_cost" class="block text-sm font-medium text-gray-700">Custo Unitário</label>
                            <input type="number" step="0.01" id="products_${productIndex}_unit_cost" name="products[${productIndex}][unit_cost]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                    </div>
                `;

                container.appendChild(productDiv);

                // Add event listener to remove button
                productDiv.querySelector('.remove-product').addEventListener('click', () => {
                    productDiv.remove();
                });

                productIndex++;
            }

            // Add product button event
            document.getElementById('add-product')?.addEventListener('click', addProductField);

            // Initialize remove buttons for existing products
            document.querySelectorAll('.remove-product').forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('.product-item').remove();
                });
            });
        </script>
    @endpush
@endsection
