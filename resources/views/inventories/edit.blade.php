@extends('layouts.app')

@section('title', 'Processo de Inventário #' . $inventory->id)

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Cabeçalho do Processo -->
            <div class="bg-white shadow-xl rounded-lg overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-purple-600 to-purple-800 px-6 py-5">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-2xl font-bold text-white">Processo de Inventário #{{ $inventory->id }}</h1>
                            <p class="mt-1 text-purple-100">Realize a contagem e conferência dos itens</p>
                        </div>
                        <div class="flex space-x-3">
                        <span class="px-3 py-1 bg-white text-purple-700 rounded-full text-sm font-semibold">
                            {{ $inventory->status }}
                        </span>
                            <a href="{{ route('inventories.index') }}"
                               class="inline-flex items-center px-3 py-1 bg-purple-500 text-white rounded-md hover:bg-purple-400 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                                </svg>
                                Voltar
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Cards de Progresso -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 p-6">
                    <div class="bg-purple-50 rounded-lg p-4 border border-purple-100">
                        <div class="text-sm text-purple-600 font-medium">Total de Itens</div>
                        <div class="text-2xl font-bold text-purple-800">{{ $inventory->items->count() }}</div>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4 border border-green-100">
                        <div class="text-sm text-green-600 font-medium">Itens Conferidos</div>
                        <div class="text-2xl font-bold text-green-800">
                            {{ $inventory->items->whereNotNull('real_amount')->count() }}
                        </div>
                    </div>
                    <div class="bg-yellow-50 rounded-lg p-4 border border-yellow-100">
                        <div class="text-sm text-yellow-600 font-medium">Itens com Divergência</div>
                        <div class="text-2xl font-bold text-yellow-800">
                            {{ $inventory->items->filter(function($item) {
                                return $item->real_amount !== $item->product->quantity;
                            })->count() }}
                        </div>
                    </div>
                    <div class="bg-blue-50 rounded-lg p-4 border border-blue-100">
                        <div class="text-sm text-blue-600 font-medium">Progresso</div>
                        <div class="text-2xl font-bold text-blue-800">
                            {{ round(($inventory->items->whereNotNull('real_amount')->count() / max($inventory->items->count(), 1)) * 100) }}%
                        </div>
                    </div>
                </div>

                <!-- Barra de Progresso -->
                <div class="px-6 pb-6">
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        @php
                            $progress = ($inventory->items->whereNotNull('real_amount')->count() / max($inventory->items->count(), 1)) * 100;
                        @endphp
                        <div class="bg-purple-600 h-2.5 rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Informações Gerais do Inventário -->
            <div class="bg-white shadow-xl rounded-lg overflow-hidden mb-6">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800">Informações do Inventário</h2>
                </div>
                <div class="p-6">
                    <form action="{{ route('inventories.update', $inventory->id) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Status -->
{{--                            <div>--}}
{{--                                <label class="block text-sm font-medium text-gray-700 mb-2">Status do Inventário</label>--}}
{{--                                <div class="flex space-x-4">--}}
{{--                                    <label class="inline-flex items-center">--}}
{{--                                        <input type="radio" name="status" value="OPEN" class="form-radio text-purple-600"--}}
{{--                                            {{ $inventory->status == 'OPEN' ? 'checked' : '' }}>--}}
{{--                                        <span class="ml-2">Aberto</span>--}}
{{--                                    </label>--}}
{{--                                    <label class="inline-flex items-center">--}}
{{--                                        <input type="radio" name="status" value="STOPPED" class="form-radio text-yellow-600"--}}
{{--                                            {{ $inventory->status == 'STOPPED' ? 'checked' : '' }}>--}}
{{--                                        <span class="ml-2">Pausado</span>--}}
{{--                                    </label>--}}
{{--                                    <label class="inline-flex items-center">--}}
{{--                                        <input type="radio" name="status" value="CLOSED" class="form-radio text-green-600"--}}
{{--                                            {{ $inventory->status == 'CLOSED' ? 'checked' : '' }}>--}}
{{--                                        <span class="ml-2">Fechado</span>--}}
{{--                                    </label>--}}
{{--                                </div>--}}
{{--                            </div>--}}

                            <!-- Data de Início -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Data de Início</label>
                                <div class="text-gray-900">{{ \Carbon\Carbon::parse($inventory->start_date)->format('d/m/Y H:i') }}</div>
                            </div>

                            <!-- Data de Fim -->
{{--                            <div>--}}
{{--                                <label class="block text-sm font-medium text-gray-700 mb-2">Data de Fim</label>--}}
{{--                                <input type="datetime-local" name="end_date" value="{{ old('end_date', $inventory->end_date) }}"--}}
{{--                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500">--}}
{{--                            </div>--}}

                            <!-- Observações do Inventário -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Observações Gerais</label>
                                <textarea name="observations" rows="2"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500"
                                          placeholder="Observações sobre o inventário...">{{ old('observations', $inventory->observations) }}</textarea>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition-colors">
                                Atualizar Observação
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Itens do Inventário - Área de Contagem -->
            <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-800">Contagem de Itens</h2>
                    <div class="flex space-x-2">
                        <input type="text" id="filterInput" placeholder="Buscar produto..."
                               class="px-3 py-1 border border-gray-300 rounded-md text-sm focus:ring-purple-500 focus:border-purple-500">
                        <select id="filterStatus" class="px-3 py-1 border border-gray-300 rounded-md text-sm focus:ring-purple-500 focus:border-purple-500">
                            <option value="all">Todos</option>
                            <option value="pending">Pendentes</option>
                            <option value="counted">Conferidos</option>
                            <option value="divergent">Com Divergência</option>
                        </select>
                    </div>
                </div>

                <div class="p-6">
                    <form id="inventoryForm" method="POST" action="#" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <!-- Lista de Itens para Contagem -->
                        <div class="space-y-4" id="itemsList">
                            @foreach($inventory->items as $index => $item)
                                <div class="item-card border rounded-lg p-4 hover:shadow-md transition-shadow"
                                     data-product="{{ strtolower($item->product->name) }}"
                                     data-status="{{ $item->real_amount ? ($item->real_amount != $item->product->quantity ? 'divergent' : 'counted') : 'pending' }}">
                                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                        <!-- Informações do Produto -->
                                        <div class="flex-1">
                                            <div class="flex items-center">
                                                <h3 class="text-lg font-medium text-gray-900">{{ $item->product->name }}</h3>
                                                @if($item->real_amount)
                                                    <span class="ml-2 px-2 py-0.5 text-xs rounded-full
                                                {{ $item->real_amount == $item->product->quantity ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ $item->real_amount == $item->product->quantity ? 'OK' : 'Divergente' }}
                                            </span>
                                                @else
                                                    <span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-800">
                                                Pendente
                                            </span>
                                                @endif
                                            </div>
                                            <div class="mt-1 grid grid-cols-2 md:grid-cols-4 gap-2 text-sm">
                                                <div>
                                                    <span class="text-gray-500">Código:</span>
                                                    <span class="ml-1 font-mono">{{ $item->product->code ?? 'N/A' }}</span>
                                                </div>
                                                <div>
                                                    <span class="text-gray-500">Sistema:</span>
                                                    <span class="ml-1 font-bold">{{ $item->product->quantity }}</span>
                                                </div>
                                                <div>
                                                    <span class="text-gray-500">Contado:</span>
                                                    <span class="ml-1 font-bold {{ $item->real_amount != $item->product->quantity ? 'text-yellow-600' : '' }}">
                                                {{ $item->real_amount ?? '---' }}
                                            </span>
                                                </div>
                                                <div>
                                                    <span class="text-gray-500">Diferença:</span>
                                                    <span class="ml-1 font-bold {{ $item->real_amount ? ($item->real_amount > $item->product->quantity ? 'text-green-600' : 'text-red-600') : '' }}">
                                                {{ $item->real_amount ? ($item->real_amount - $item->product->quantity) : '---' }}
                                            </span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Campos de Contagem -->
                                        <div class="flex flex-col md:flex-row gap-3 items-end">
                                            <input type="hidden" name="items[{{ $index }}][product_id]" value="{{ $item->product_id }}">

                                            <div>
                                                <label class="block text-xs text-gray-500 mb-1">Quantidade Contada</label>
                                                <input type="number" name="items[{{ $index }}][real_amount]"
                                                       value="{{ old('items.'.$index.'.real_amount', $item->real_amount) }}"
                                                       class="w-24 px-3 py-2 border border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500"
                                                       min="0" step="1">
                                            </div>

                                            <div class="flex-1">
                                                <label class="block text-xs text-gray-500 mb-1">Motivação</label>
                                                <input type="text" name="items[{{ $index }}][reason]"
                                                       value="{{ old('items.'.$index.'.reason', $item->reason) }}"
                                                       class="w-48 px-3 py-2 border border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500"
                                                       placeholder="Motivo da Divergencia">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Botões de Ação -->
                        <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                            <button type="button" id="saveProgress"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                                Salvar Progresso
                            </button>

                            <div class="flex space-x-3">
                                <button type="button" id="markAllCounted"
                                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                                    Marcar Todos como Conferidos
                                </button>
                                <button type="submit"
                                        class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition-colors">
                                    Finalizar Contagem
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Filtros de busca
                const filterInput = document.getElementById('filterInput');
                const filterStatus = document.getElementById('filterStatus');
                const itemsList = document.getElementById('itemsList');
                const itemCards = document.querySelectorAll('.item-card');

                function filterItems() {
                    const searchTerm = filterInput.value.toLowerCase();
                    const statusFilter = filterStatus.value;

                    itemCards.forEach(card => {
                        const productName = card.dataset.product;
                        const itemStatus = card.dataset.status;

                        const matchesSearch = productName.includes(searchTerm);
                        const matchesStatus = statusFilter === 'all' || itemStatus === statusFilter;

                        if (matchesSearch && matchesStatus) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                }

                filterInput.addEventListener('input', filterItems);
                filterStatus.addEventListener('change', filterItems);

                // Marcar todos como conferidos
                document.getElementById('markAllCounted').addEventListener('click', function() {
                    const productQuantities = @json($inventory->items->pluck('product.quantity', 'product_id'));

                    document.querySelectorAll('input[name$="[real_amount]"]').forEach(input => {
                        const match = input.name.match(/items\[(\d+)\]\[real_amount\]/);
                        if (match) {
                            const index = match[1];
                            const productId = document.querySelector(`input[name="items[${index}][product_id]"]`).value;
                            input.value = productQuantities[productId] || 0;
                        }
                    });
                });

                // Salvar progresso (AJAX)
                document.getElementById('saveProgress').addEventListener('click', function() {
                    const form = document.getElementById('inventoryForm');
                    const formData = new FormData(form);

                    fetch('{{ route("inventories.save-progress", $inventory->id) }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                        body: formData
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Progresso salvo com sucesso!');
                            }
                        })
                        .catch(error => {
                            console.error('Erro:', error);
                        });
                });

                // Validação antes de finalizar
                document.getElementById('inventoryForm').addEventListener('submit', function(e) {
                    const pendingItems = document.querySelectorAll('.item-card[data-status="pending"]');

                    if (pendingItems.length > 0) {
                        if (!confirm('Existem itens pendentes. Deseja finalizar mesmo assim?')) {
                            e.preventDefault();
                        }
                    }
                });
            });
        </script>
    @endpush

    <style>
        .item-card {
            transition: all 0.2s ease-in-out;
        }
        .item-card:hover {
            transform: translateX(4px);
        }
    </style>
@endsection
