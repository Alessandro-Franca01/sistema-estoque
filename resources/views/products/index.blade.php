@extends('layouts.app')

@section('title', 'Listagem de Produtos')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gray-800 text-white px-6 py-4 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                <h1 class="text-2xl font-semibold">Produtos</h1>
                <a href="{{ route('products.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline text-center">
                    Novo Produto
                </a>
            </div>

            <div class="p-6">
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <form action="{{ route('products.index') }}" method="GET" class="mb-6">
                    <div class="flex flex-wrap gap-4">
                        <input type="text" name="search" placeholder="Buscar por nome ou código..." value="{{ request('search') }}"
                               class="flex-1 min-w-[200px] shadow border rounded py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline" />

                        <select name="category_id"
                                class="min-w-[180px] shadow border rounded py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline">
                            <option value="">Todas as Categorias</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->name }}</option>
                            @endforeach
                        </select>

                        <select name="status"
                                class="min-w-[150px] shadow border rounded py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline">
                            <option value="">Todos os Status</option>
                            <option value="1" @selected(request('status') === '1')>Ativo</option>
                            <option value="0" @selected(request('status') === '0')>Inativo</option>
                        </select>

                        <select name="sort_by"
                                class="min-w-[180px] shadow border rounded py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline">
                            <option value="name" @selected(request('sort_by', 'name') == 'name')>Ordenar por Nome</option>
                            <option value="price" @selected(request('sort_by') == 'price')>Ordenar por Preço</option>
                            <option value="stock_quantity" @selected(request('sort_by') == 'stock_quantity')>Ordenar por Estoque</option>
                        </select>

                        <select name="sort_order"
                                class="min-w-[150px] shadow border rounded py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline">
                            <option value="asc" @selected(request('sort_order', 'asc') == 'asc')>Crescente</option>
                            <option value="desc" @selected(request('sort_order') == 'desc')>Decrescente</option>
                        </select>

                        <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Filtrar
                        </button>

                        <a href="{{ route('products.index') }}"
                           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Limpar
                        </a>
                    </div>
                </form>

                @if ($products->isEmpty())
                    <p class="text-gray-600">Nenhum produto cadastrado ainda ou encontrado com os filtros aplicados.</p>
                @else
                    {{-- Container para a tabela com rolagem horizontal --}}
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoria</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preço</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estoque</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($products as $product)
                                    <tr> {{-- Removidas as classes de 'flex flex-col' e estilizações mobile --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $product->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $product->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $product->code }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $product->category->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">R$ {{ number_format($product->price, 2, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $product->stock_quantity ?? 0 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if ($product->is_active)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Ativo</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inativo</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                            <a href="{{ route('products.show', $product->id) }}" class="text-indigo-600 hover:text-indigo-900">Ver</a>
                                            <a href="{{ route('products.edit', $product->id) }}" class="text-blue-600 hover:text-blue-900">Editar</a>
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline-block"
                                                onsubmit="return confirm('Tem certeza que deseja excluir este produto?');">
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
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
