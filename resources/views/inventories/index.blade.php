@extends('layouts.app')

@section('title', 'Listagem de Inventários')

@section('content')
    <div class="container mx-auto px-4 py-8 mt-4">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gray-800 text-white px-6 py-4 flex justify-between items-center">
                <h1 class="text-2xl font-semibold">Inventários</h1>
                <a href="{{ route('inventories.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Novo Inventário
                </a>
            </div>

            <div class="p-6">
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if ($inventories->isEmpty())
                    <p class="text-gray-600">Nenhum inventário cadastrado ainda.</p>
                @else
                    <div class="flex flex-col items-center">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                            <tr>
                                <th class="px-4 py-2">
                                    ID
                                </th>
                                <th class="px-4 py-2">
                                    Data de Início
                                </th>
                                <th class="px-4 py-2">
                                    Data de Fim
                                </th>
                                <th class="px-4 py-2">
                                    Status
                                </th>
                                <th class="px-4 py-2">
                                    Ações
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($inventories as $inventory)
                                <tr>
                                    <td class="px-4 py-">
                                        <p class="text-gray-900 whitespace-no-wrap">{{ $inventory->id }}</p>
                                    </td>
                                    <td class="px-4 py-">
                                        <p class="text-gray-900 whitespace-no-wrap">{{ $inventory->start_date }}</p>
                                    </td>
                                    <td class="px-4 py-">
                                        <p class="text-gray-900 whitespace-no-wrap">{{ $inventory->end_date ?? 'N/A' }}</p>
                                    </td>
                                    <td class="px-4 py-">
                                        <p class="text-gray-900 whitespace-no-wrap">{{ $inventory->status }}</p>
                                    </td>
                                    <td class="px-4 py-">
                                        <a href="{{ route('inventories.show', $inventory->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">Ver</a>
                                        <a href="{{ route('inventories.edit', $inventory->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">Editar</a>
                                        <form action="{{ route('inventories.destroy', $inventory->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja excluir este inventário?');">
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
                @endif
            </div>
        </div>
    </div>
@endsection