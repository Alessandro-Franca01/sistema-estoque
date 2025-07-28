@extends('layouts.app')

@section('title', 'Listagem de Entradas de Produtos')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gray-800 text-white px-6 py-4 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                <h1 class="text-2xl font-semibold">Entradas de Produtos</h1>
                <a href="{{ route('product_entries.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline text-center">
                    Nova Entrada
                </a>
            </div>

            <div class="p-6">
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <form action="{{ route('product_entries.index') }}" method="GET" class="mb-6">
                    <div class="flex flex-wrap gap-4">
                        <input type="text" name="search" placeholder="Buscar por produto, fornecedor ou nota fiscal..." value="{{ request('search') }}"
                               class="flex-1 min-w-[200px] shadow border rounded py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline" />

                        <select name="product_id"
                                class="min-w-[180px] shadow border rounded py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline">
                            <option value="">Todos os Produtos</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" @selected(request('product_id') == $product->id)>{{ $product->name }}</option>
                            @endforeach
                        </select>

                        <select name="supplier_id"
                                class="min-w-[180px] shadow border rounded py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline">
                            <option value="">Todos os Fornecedores</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" @selected(request('supplier_id') == $supplier->id)>{{ $supplier->company_name }}</option>
                            @endforeach
                        </select>

                        <input type="date" name="start_date" placeholder="Data Inicial" value="{{ request('start_date') }}"
                               class="min-w-[180px] shadow border rounded py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline" />

                        <input type="date" name="end_date" placeholder="Data Final" value="{{ request('end_date') }}"
                               class="min-w-[180px] shadow border rounded py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline" />

                        <select name="sort_by"
                                class="min-w-[180px] shadow border rounded py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline">
                            <option value="entry_date" @selected(request('sort_by', 'entry_date') == 'entry_date')>Ordenar por Data</option>
                            <option value="quantity" @selected(request('sort_by') == 'quantity')>Ordenar por Quantidade</option>
                            <option value="total_cost" @selected(request('sort_by') == 'total_cost')>Ordenar por Custo Total</option>
                        </select>

                        <select name="sort_order"
                                class="min-w-[150px] shadow border rounded py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline">
                            <option value="desc" @selected(request('sort_order', 'desc') == 'desc')>Decrescente</option>
                            <option value="asc" @selected(request('sort_order') == 'asc')>Crescente</option>
                        </select>

                        <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Filtrar
                        </button>

                        <a href="{{ route('product_entries.index') }}"
                           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Limpar
                        </a>
                    </div>
                </form>

                @if ($entries->isEmpty())
                    <p class="text-gray-600">Nenhuma entrada de produto cadastrada ainda ou encontrada com os filtros aplicados.</p>
                @else
                    {{-- Container para a tabela com rolagem horizontal --}}
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produto</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fornecedor</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantidade</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Custo Unitário</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Custo Total</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nota Fiscal</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data de Entrada</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($entries as $entry)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $entry->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $entry->product->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $entry->supplier->company_name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $entry->quantity }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">R$ {{ number_format($entry->unit_cost, 2, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">R$ {{ number_format($entry->total_cost, 2, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $entry->invoice_number ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $entry->entry_date->format('d/m/Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                            <a href="{{ route('product_entries.show', $entry->id) }}" class="text-indigo-600 hover:text-indigo-900">Ver</a>
                                            <a href="{{ route('product_entries.edit', $entry->id) }}" class="text-blue-600 hover:text-blue-900">Editar</a>
                                            <form action="{{ route('product_entries.destroy', $entry->id) }}" method="POST" class="inline-block"
                                                onsubmit="return confirm('Tem certeza que deseja excluir esta entrada?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Excluir</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $entries->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection