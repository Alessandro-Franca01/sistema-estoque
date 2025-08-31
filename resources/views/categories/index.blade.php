@extends('layouts.app')

@section('title', 'Listagem de Categorias')

@section('content')
    @php
        $user = auth()->user();
        $canEdit = $user?->hasAnyRole(['administrativo', 'almoxarife']);
        $canDeactivate = $user?->hasRole('administrativo');
    @endphp

    <div class="container mx-auto px-4 py-8 mt-4">
        <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gray-800 text-white px-6 py-4 flex justify-between items-center">
                <h1 class="text-2xl font-semibold">Categorias</h1>
                <a href="{{ route('categories.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Nova Categoria
                </a>
            </div>

            <div class="flex flex-col items-center overflow-x-auto">
                @if (session('success'))
                    <div class="bg-green-100 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if ($categories->isEmpty())
                    <p class="text-gray-600">Nenhuma categoria cadastrada ainda.</p>
                @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                        <tr>
                            <th class="px-4 py-2">
                                Nome
                            </th>
                            <th class="px-4 py-2">
                                Descrição
                            </th>
                            <th class="px-4 py-2">
                                Status
                            </th>
                            @if($canEdit)
                            <th class="px-4 py-2">
                                Editar
                            </th>
                            @endif
                            @if($canDeactivate)
                            <th class="px-4 py-2">
                                Ação
                            </th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($categories as $category)
                            <tr>
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
                                @if($canEdit)
                                <td class="px-4 py-2 text-center">
                                    <a href="{{ route('categories.edit', $category->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.38-2.827-2.828z" />
                                        </svg>
                                    </a>
                                </td>
                                @endif
                                @if($canDeactivate)
                                    <td class="px-4 py-2 text-center">
                                    <form action="{{ route('categories.toggle-status', $category->id) }}" method="POST" class="inline-block mr-3" onsubmit="return confirm('Tem certeza que deseja {{ $category->is_active ? 'desativar' : 'ativar' }} esta categoria?');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="{{ $category->is_active ? 'text-yellow-600 hover:text-yellow-800 b' : 'text-green-600 hover:text-green-800' }}">
                                            {{ $category->is_active ? 'Desativar' : 'Ativar' }}
                                        </button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                    <div class="mt-4">
                        {{ $categories->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
