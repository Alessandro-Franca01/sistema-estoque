<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Entrada') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('entries.update', $entry) }}">
                        @csrf
                        @method('PUT')

                        <!-- Supplier -->
                        <div>
                            <x-input-label for="supplier_id" :value="__('Fornecedor')" />
                            <select id="supplier_id" name="supplier_id" class="block mt-1 w-full" required>
                                <option value="">Selecione um fornecedor</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ old('supplier_id', $entry->supplier_id) == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('supplier_id')" class="mt-2" />
                        </div>

                        <!-- Entry Date -->
                        <div class="mt-4">
                            <x-input-label for="entry_date" :value="__('Data de Entrada')" />
                            <x-text-input id="entry_date" class="block mt-1 w-full" type="date" name="entry_date" :value="old('entry_date', $entry->entry_date)" required />
                            <x-input-error :messages="$errors->get('entry_date')" class="mt-2" />
                        </div>

                        <!-- Observation -->
                        <div class="mt-4">
                            <x-input-label for="observation" :value="__('Observação')" />
                            <textarea id="observation" name="observation" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('observation', $entry->observation) }}</textarea>
                            <x-input-error :messages="$errors->get('observation')" class="mt-2" />
                        </div>

                        <!-- Is Existing -->
                        <div class="mt-4">
                            <input type="checkbox" id="is_existing" name="is_existing" value="1" {{ old('is_existing', $entry->is_existing) ? 'checked' : '' }}>
                            <x-input-label for="is_existing" class="inline" :value="__('É Existente?')" />
                            <x-input-error :messages="$errors->get('is_existing')" class="mt-2" />
                        </div>

                        <!-- Invoice Number -->
                        <div class="mt-4">
                            <x-input-label for="invoice_number" :value="__('Número da Nota Fiscal')" />
                            <x-text-input id="invoice_number" class="block mt-1 w-full" type="text" name="invoice_number" :value="old('invoice_number', $entry->invoice_number)" />
                            <x-input-error :messages="$errors->get('invoice_number')" class="mt-2" />
                        </div>

                        <!-- Contract Number -->
                        <div class="mt-4">
                            <x-input-label for="contract_number" :value="__('Número do Contrato')" />
                            <x-text-input id="contract_number" class="block mt-1 w-full" type="text" name="contract_number" :value="old('contract_number', $entry->contract_number)" />
                            <x-input-error :messages="$errors->get('contract_number')" class="mt-2" />
                        </div>

                        <!-- Batch Number (for the entry itself, if applicable) -->
                        <div class="mt-4">
                            <x-input-label for="batch_number" :value="__('Número do Lote (Entrada Geral)')" />
                            <x-text-input id="batch_number" class="block mt-1 w-full" type="text" name="batch_number" :value="old('batch_number', $entry->batch_number)" />
                            <x-input-error :messages="$errors->get('batch_number')" class="mt-2" />
                        </div>

                        <!-- Value (total value of the entry) -->
                        <div class="mt-4">
                            <x-input-label for="value" :value="__('Valor Total da Entrada')" />
                            <x-text-input id="value" class="block mt-1 w-full" type="number" step="0.01" name="value" :value="old('value', $entry->value)" />
                            <x-input-error :messages="$errors->get('value')" class="mt-2" />
                        </div>

                        <h3 class="font-semibold text-lg text-gray-800 leading-tight mt-6 mb-4">Produtos da Entrada</h3>
                        <div id="products-container">
                            @foreach ($entry->products as $index => $product)
                                <div class="product-item mt-4 p-4 border rounded-md relative">
                                    <button type="button" class="remove-product absolute top-2 right-2 text-red-500 hover:text-red-700">X</button>
                                    <div class="mt-2">
                                        <x-input-label for="products_{{ $index }}_product_id" :value="__('Produto')" />
                                        <select name="products[{{ $index }}][product_id]" id="products_{{ $index }}_product_id" class="block mt-1 w-full" required>
                                            <option value="">Selecione um produto</option>
                                            @foreach ($products as $p)
                                                <option value="{{ $p->id }}" {{ old("products.{$index}.product_id", $product->id) == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                                            @endforeach
                                        </select>
                                        <x-input-error messages="$errors->get('products.{{ $index }}.product_id')" class="mt-2" />
                                    </div>
                                    <div class="mt-2">
                                        <x-input-label for="products_{{ $index }}_batch_number" :value="__('Número do Lote (Produto)')" />
                                        <x-text-input id="products_{{ $index }}_batch_number" class="block mt-1 w-full" type="text" name="products[{{ $index }}][batch_number]" :value="old("products.{$index}.batch_number", $product->pivot->batch_number)" />
                                        <x-input-error messages="$errors->get('products.{{ $index }}.batch_number')" class="mt-2" />
                                    </div>
                                    <div class="mt-2">
                                        <x-input-label for="products_{{ $index }}_quantity" :value="__('Quantidade')" />
                                        <x-text-input id="products_{{ $index }}_quantity" class="block mt-1 w-full" type="number" name="products[{{ $index }}][quantity]" :value="old("products.{$index}.quantity", $product->pivot->quantity)" required />
                                        <x-input-error messages="$errors->get('products.{{ $index }}.quantity')" class="mt-2" />
                                    </div>
                                    <div class="mt-2">
                                        <x-input-label for="products_{{ $index }}_unit_cost" :value="__('Custo Unitário')" />
                                        <x-text-input id="products_{{ $index }}_unit_cost" class="block mt-1 w-full" type="number" step="0.01" name="products[{{ $index }}][unit_cost]" :value="old("products.{$index}.unit_cost", $product->pivot->unit_cost)" required />
                                        <x-input-error messages="$errors->get('products.{{ $index }}.unit_cost')" class="mt-2" />
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" id="add-product" class="btn btn-secondary bg-gray-200 px-4 py-2 rounded-md mt-4">Adicionar Produto</button>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Atualizar Entrada') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            let productIndex = {{ count($entry->products) }};
            const products = @json($products);

            function addProductField() {
                const container = document.getElementById('products-container');
                const productDiv = document.createElement('div');
                productDiv.classList.add('product-item', 'mt-4', 'p-4', 'border', 'rounded-md', 'relative');
                productDiv.innerHTML = `
                    <button type="button" class="remove-product absolute top-2 right-2 text-red-500 hover:text-red-700">X</button>
                    <div class="mt-2">
                        <x-input-label for="products_${productIndex}_product_id" :value="__('Produto')" />
                        <select name="products[${productIndex}][product_id]" id="products_${productIndex}_product_id" class="block mt-1 w-full" required>
                            <option value="">Selecione um produto</option>
                            ${products.map(product => `<option value="${product.id}">${product.name}</option>`).join('')}
                        </select>
                        <x-input-error messages="$errors->get('products.${productIndex}.product_id')" class="mt-2" />
                    </div>
                    <div class="mt-2">
                        <x-input-label for="products_${productIndex}_batch_number" :value="__('Número do Lote (Produto)')" />
                        <x-text-input id="products_${productIndex}_batch_number" class="block mt-1 w-full" type="text" name="products[${productIndex}][batch_number]" />
                        <x-input-error messages="$errors->get('products.${productIndex}.batch_number')" class="mt-2" />
                    </div>
                    <div class="mt-2">
                        <x-input-label for="products_${productIndex}_quantity" :value="__('Quantidade')" />
                        <x-text-input id="products_${productIndex}_quantity" class="block mt-1 w-full" type="number" name="products[${productIndex}][quantity]" required />
                        <x-input-error messages="$errors->get('products.${productIndex}.quantity')" class="mt-2" />
                    </div>
                    <div class="mt-2">
                        <x-input-label for="products_${productIndex}_unit_cost" :value="__('Custo Unitário')" />
                        <x-text-input id="products_${productIndex}_unit_cost" class="block mt-1 w-full" type="number" step="0.01" name="products[${productIndex}][unit_cost]" required />
                        <x-input-error messages="$errors->get('products.${productIndex}.unit_cost')" class="mt-2" />
                    </div>
                `;
                container.appendChild(productDiv);

                productDiv.querySelector('.remove-product').addEventListener('click', () => {
                    productDiv.remove();
                });

                productIndex++;
            }

            document.getElementById('add-product').addEventListener('click', addProductField);

            document.querySelectorAll('.remove-product').forEach(button => {
                button.addEventListener('click', (event) => {
                    event.target.closest('.product-item').remove();
                });
            });
        </script>
    @endpush
</x-app-layout> 