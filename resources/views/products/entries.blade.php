@extends('layouts.app')

@section('title', 'Histórico de Entradas do Produto')

@section('content')
<div class="container mx-auto px-4 py-8 mt-4">
    <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gray-800 text-white px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-semibold">Histórico de Entradas: {{ $product->name }}</h1>
            <div class="flex space-x-2">
                <a href="{{ route('products.show', $product->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-arrow-left mr-1"></i> Voltar ao Produto
                </a>
                <a href="{{ route('product_entries.create', ['product_id' => $product->id]) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-plus mr-1"></i> Nova Entrada
                </a>
            </div>
        </div>

        <!-- Informações do Produto -->
        <div class="p-6 bg-gray-50 border-b">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Código</p>
                    <p class="text-base font-medium">{{ $product->code }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Categoria</p>
                    <p class="text-base font-medium">{{ $product->category->name }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Preço de Venda</p>
                    <p class="text-base font-medium">R$ {{ number_format($product->price, 2, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Estoque Atual</p>
                    <p class="text-base font-bold text-blue-600">{{ $product->stock_quantity }} unidades</p>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="p-6 border-b">
            <form action="{{ route('products.entries', $product->id) }}" method="GET" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <label for="supplier_id" class="block text-sm font-medium text-gray-700 mb-1">Fornecedor</label>
                    <select name="supplier_id" id="supplier_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <option value="">Todos os fornecedores</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" @selected(request('supplier_id') == $supplier->id)>
                                {{ $supplier->company_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="flex-1 min-w-[200px]">
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Data Inicial</label>
                    <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </div>
                
                <div class="flex-1 min-w-[200px]">
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Data Final</label>
                    <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </div>
                
                <div class="flex items-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-filter mr-1"></i> Filtrar
                    </button>
                </div>
                
                @if(request('supplier_id') || request('start_date') || request('end_date'))
                    <div class="flex items-end">
                        <a href="{{ route('products.entries', $product->id) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-times mr-1"></i> Limpar Filtros
                        </a>
                    </div>
                @endif
            </form>
        </div>

        <!-- Resumo -->
        <div class="p-6 bg-blue-50 border-b">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white p-4 rounded-lg shadow">
                    <p class="text-sm font-medium text-gray-500">Total de Entradas</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $productEntries->total() }}</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <p class="text-sm font-medium text-gray-500">Quantidade Total</p>
                    <p class="text-2xl font-bold text-green-600">{{ $totalQuantity }} unidades</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <p class="text-sm font-medium text-gray-500">Custo Total</p>
                    <p class="text-2xl font-bold text-red-600">R$ {{ number_format($totalCost, 2, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Tabela de Entradas -->
        <div class="p-6">
            @if($productEntries->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID
                                </th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Data
                                </th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Fornecedor
                                </th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Quantidade
                                </th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Custo Unit.
                                </th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Custo Total
                                </th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nota Fiscal
                                </th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($productEntries as $entry)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-4 whitespace-nowrap">
                                        {{ $entry->id }}
                                    </td>
                                    <td class="py-3 px-4 whitespace-nowrap">
                                        {{ $entry->entry_date->format('d/m/Y') }}
                                    </td>
                                    <td class="py-3 px-4 whitespace-nowrap">
                                        {{ $entry->supplier->company_name }}
                                    </td>
                                    <td class="py-3 px-4 whitespace-nowrap font-medium">
                                        {{ $entry->quantity }}
                                    </td>
                                    <td class="py-3 px-4 whitespace-nowrap">
                                        R$ {{ number_format($entry->unit_cost, 2, ',', '.') }}
                                    </td>
                                    <td class="py-3 px-4 whitespace-nowrap font-medium text-blue-600">
                                        R$ {{ number_format($entry->total_cost, 2, ',', '.') }}
                                    </td>
                                    <td class="py-3 px-4 whitespace-nowrap">
                                        {{ $entry->invoice_number ?: 'N/A' }}
                                    </td>
                                    <td class="py-3 px-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('product_entries.show', $entry->id) }}" class="text-blue-600 hover:text-blue-900">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('product_entries.edit', $entry->id) }}" class="text-yellow-600 hover:text-yellow-900">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('product_entries.destroy', $entry->id) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir esta entrada?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4">
                    {{ $productEntries->appends(request()->query())->links() }}
                </div>
            @else
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                Nenhuma entrada encontrada para este produto.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection