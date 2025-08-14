@extends('layouts.app')

@section('title', 'Listagem de Categorias')

@section('content')
    <div class="container mx-auto px-4 py-8 mt-4">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gray-800 text-white px-6 py-4 flex justify-between items-center">
                <h1 class="text-2xl font-semibold">Categorias</h1>
                <a href="{{ route('categories.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Nova Categoria
                </a>
            </div>

            <div class="p-6">
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if ($categories->isEmpty())
                    <p class="text-gray-600">Nenhuma categoria cadastrada ainda.</p>
                @else
                    <div class="overflow-x-auto">
                        <div class="inline-block min-w-full align-middle">
                            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                            <tr>
                                <th class="px-4 py-2">
                                    ID
                                </th>
                                <th class="px-4 py-2">
                                    Nome
                                </th>
                                <th class="px-4 py-2">
                                    Descrição
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
                            @foreach ($categories as $category)
                                <tr>
                                    <td class="px-4 py-2">
                                        <p class="text-gray-900 whitespace-no-wrap">{{ $category->id }}</p>
                                    </td>
                                    <td class="px-4 py-2">
                                        <p class="text-gray-900 whitespace-no-wrap">{{ $category->name }}</p>
                                    </td>
                                    <td class="px-4 py-2">
                                        <p class="text-gray-900 whitespace-no-wrap">{{ $category->description ?? 'N/A' }}</p>
                                    </td>
                                    <td class="px-4 py-2">
                                        @if ($category->is_active)
                                            <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                            <span aria-hidden="true" class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                            <span class="relative">Ativa</span>
                                        </span>
                                        @else
                                            <span class="relative inline-block px-3 py-1 font-semibold text-red-900 leading-tight">
                                            <span aria-hidden="true" class="absolute inset-0 bg-red-200 opacity-50 rounded-full"></span>
                                            <span class="relative">Inativa</span>
                                        </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        <a href="{{ route('categories.edit', $category->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.38-2.827-2.828z" />
                                            </svg>
                                            Editar
                                        </a>
                                        <form action="#" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja excluir esta categoria?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm6 0a1 1 0 012 0v6a1 1 0 11-2 0V8z" clip-rule="evenodd" />
                                                </svg>
                                                Excluir
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
                    <div class="mt-4">
                        {{ $categories->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection