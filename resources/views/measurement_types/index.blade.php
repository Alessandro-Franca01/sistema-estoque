@extends('layouts.app')

@section('title', 'Tipos de Medida')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gray-800 text-white px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-semibold">Tipos de Medida</h1>
            <a href="{{ route('measurement-types.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Novo Tipo</a>
        </div>
        <div class="p-6">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th class="px-6 py-3">ID</th>
                            <th class="px-6 py-3">Nome</th>
                            <th class="px-6 py-3">Sigla</th>
                            <th class="px-6 py-3">Descrição</th>
                            <th class="px-6 py-3">Medida Usada</th>
                            <th class="px-6 py-3">Ativo</th>
                            <th class="px-6 py-3">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($measurementTypes as $type)
                            <tr>
                                <td class="px-6 py-4">{{ $type->id }}</td>
                                <td class="px-6 py-4">{{ $type->name }}</td>
                                <td class="px-6 py-4">{{ $type->acronym }}</td>
                                <td class="px-6 py-4">{{ $type->description }}</td>
                                <td class="px-6 py-4">{{ $type->used_measurement }}</td>
                                <td class="px-6 py-4">
                                    @if($type->is_active)
                                        <span class="px-2 py-1 bg-green-200 text-green-800 rounded-full text-xs">Sim</span>
                                    @else
                                        <span class="px-2 py-1 bg-red-200 text-red-800 rounded-full text-xs">Não</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 space-x-2">
                                    <a href="{{ route('measurement-types.show', $type->id) }}" class="text-indigo-600 hover:text-indigo-900">Ver</a>
                                    <a href="{{ route('measurement-types.edit', $type->id) }}" class="text-blue-600 hover:text-blue-900">Editar</a>
                                    <form action="{{ route('measurement-types.destroy', $type->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja excluir este tipo?');">
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
                {{ $measurementTypes->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 