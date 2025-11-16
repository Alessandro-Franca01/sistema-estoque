@extends('layouts.app')

@section('title', 'Editar Inventário')

@section('content')
<div class="container mx-auto px-4 py-8 mt-4">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gray-800 text-white px-6 py-4">
            <h1 class="text-2xl font-semibold">Editar Inventário #{{ $inventory->id }}</h1>
        </div>

        <div class="p-6">
            <form action="{{ route('inventories.update', $inventory->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                    <select name="status" id="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="OPEN" {{ $inventory->status == 'OPEN' ? 'selected' : '' }}>Aberto</option>
                        <option value="STOPPED" {{ $inventory->status == 'STOPPED' ? 'selected' : '' }}>Parado</option>
                        <option value="CLOSED" {{ $inventory->status == 'CLOSED' ? 'selected' : '' }}>Fechado</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="end_date" class="block text-gray-700 text-sm font-bold mb-2">Data de Fim</label>
                    <input type="datetime-local" name="end_date" id="end_date" value="{{ old('end_date', $inventory->end_date) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label for="observations" class="block text-gray-700 text-sm font-bold mb-2">Observações do Inventário</label>
                    <textarea name="observations" id="observations" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('observations', $inventory->observations) }}</textarea>
                </div>

                <h2 class="text-xl font-semibold mt-6 mb-4">Itens do Inventário</h2>

                <div id="items-container">
                    @foreach($inventory->items as $index => $item)
                        <div class="item border-b pb-4 mb-4">
                            <input type="hidden" name="items[{{ $index }}][product_id]" value="{{ $item->product_id }}">
                            <p><strong>Produto:</strong> {{ $item->product->name }}</p>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="items[{{ $index }}][real_amount]" class="block text-gray-700 text-sm font-bold mb-2">Quantidade Real</label>
                                    <input type="number" step="0.001" name="items[{{ $index }}][real_amount]" value="{{ old('items.'.$index.'.real_amount', $item->real_amount) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                </div>
                                <div>
                                    <label for="items[{{ $index }}][observations]" class="block text-gray-700 text-sm font-bold mb-2">Observações</label>
                                    <input type="text" name="items[{{ $index }}][observations]" value="{{ old('items.'.$index.'.observations', $item->observations) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <h3 class="text-lg font-semibold mt-6 mb-4">Adicionar Produto ao Inventário</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="product_id" class="block text-gray-700 text-sm font-bold mb-2">Produto</label>
                        <select id="product_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">Selecione um produto</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <button type="button" id="add-item" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-7">Adicionar Item</button>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-6">
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Salvar Alterações
                    </button>
                    <a href="{{ route('inventories.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                        Voltar para a lista
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addItemButton = document.getElementById('add-item');
        const itemsContainer = document.getElementById('items-container');
        const productSelect = document.getElementById('product_id');
        let itemIndex = {{ $inventory->items->count() }};

        addItemButton.addEventListener('click', function () {
            const productId = productSelect.value;
            const productName = productSelect.options[productSelect.selectedIndex].text;

            if (productId) {
                const itemHtml = `
                    <div class="item border-b pb-4 mb-4">
                        <input type="hidden" name="items[${itemIndex}][product_id]" value="${productId}">
                        <p><strong>Produto:</strong> ${productName}</p>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="items[${itemIndex}][real_amount]" class="block text-gray-700 text-sm font-bold mb-2">Quantidade Real</label>
                                <input type="number" step="0.001" name="items[${itemIndex}][real_amount]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                            <div>
                                <label for="items[${itemIndex}][observations]" class="block text-gray-700 text-sm font-bold mb-2">Observações</label>
                                <input type="text" name="items[${itemIndex}][observations]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                        </div>
                    </div>
                `;
                itemsContainer.insertAdjacentHTML('beforeend', itemHtml);
                itemIndex++;
                productSelect.value = '';
            }
        });
    });
</script>
@endpush
@endsection