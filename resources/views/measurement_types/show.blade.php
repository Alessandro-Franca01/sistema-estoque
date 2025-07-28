@extends('layouts.app')

@section('title', 'Detalhes do Tipo de Medida')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gray-800 text-white px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-semibold">Detalhes do Tipo de Medida</h1>
            <a href="{{ route('measurement-types.edit', $measurementType->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Editar</a>
        </div>
        <div class="p-6">
            <div class="mb-4">
                <span class="font-bold">Nome:</span> {{ $measurementType->name }}
            </div>
            <div class="mb-4">
                <span class="font-bold">Sigla:</span> {{ $measurementType->acronym }}
            </div>
            <div class="mb-4">
                <span class="font-bold">Descrição:</span> {{ $measurementType->description ?: 'Nenhuma descrição.' }}
            </div>
            <div class="mb-4">
                <span class="font-bold">Medida Usada:</span> {{ $measurementType->used_measurement ?: 'N/A' }}
            </div>
            <div class="mb-4">
                <span class="font-bold">Ativo:</span>
                @if($measurementType->is_active)
                    <span class="px-2 py-1 bg-green-200 text-green-800 rounded-full text-xs">Sim</span>
                @else
                    <span class="px-2 py-1 bg-red-200 text-red-800 rounded-full text-xs">Não</span>
                @endif
            </div>
            <div class="mt-8 border-t pt-4">
                <a href="{{ route('measurement-types.index') }}" class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">
                    <i class="fas fa-arrow-left mr-1"></i> Voltar para a lista
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 