@extends('layouts.app')

@section('title', 'Detalhes do Produto')

@section('content')
<div class="container mx-auto px-4 py-8 mt-4">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gray-800 text-white px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-semibold">Detalhes do Produto: {{ $product->name }}</h1>
            <div class="flex space-x-2">
                <a href="{{ route('products.edit', $product->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-edit mr-1"></i> Editar
                </a>
                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este produto?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-trash mr-1"></i> Excluir
                    </button>
                </form>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Coluna 1: Informações Básicas -->
                <div class="space-y-6">
                    <!-- Informações Básicas -->
                    <div class="border-b pb-4">
                        <h2 class="text-xl font-semibold mb-4 text-gray-800">Informações Básicas</h2>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Código</p>
                                <p class="text-base font-medium">{{ $product->code }}</p>
                            </div>
                            
                            <div>
                                <p class="text-sm font-medium text-gray-500">Categoria</p>
                                <p class="text-base font-medium">{{ $product->category->name ?? 'N/A' }}</p>
                            </div>

                            <div>
                                <p class="text-sm font-medium text-gray-500">Tipo de Medida</p>
                                <p class="text-base font-medium">{{ $product->measurementType->name ?? 'N/A' }} ({{ $product->measurementType->acronym ?? 'N/A' }})</p>
                            </div>

                            <div>
                                <p class="text-sm font-medium text-gray-500">Quantidade</p>
                                <p class="text-base font-medium">{{ $product->quantity }}</p>
                            </div>
                            
                            <div>
                                <p class="text-sm font-medium text-gray-500">Status</p>
                                <p class="text-base">
                                    @if($product->is_active)
                                        <span class="px-2 py-1 bg-green-200 text-green-800 rounded-full text-xs">Ativo</span>
                                    @else
                                        <span class="px-2 py-1 bg-red-200 text-red-800 rounded-full text-xs">Inativo</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Descrição e Observação -->
                    <div>
                        <h3 class="text-lg font-semibold mb-2 text-gray-800">Descrição e Observação</h3>
                        <div class="bg-gray-50 p-4 rounded-lg mb-4">
                            <p class="text-sm font-medium text-gray-500">Descrição</p>
                            <p class="text-gray-700">{{ $product->description ?: 'Nenhuma descrição disponível.' }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm font-medium text-gray-500">Observação</p>
                            <p class="text-gray-700">{{ $product->observation ?: 'Nenhuma observação disponível.' }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Coluna 2: Ações Relacionadas -->
                <div class="space-y-6">
                    <div class="border-b pb-4">
                        <h2 class="text-xl font-semibold mb-4 text-gray-800">Ações Relacionadas</h2>
                        <div class="grid grid-cols-1 gap-4">
                            <div class="bg-green-50 p-4 rounded-lg">
                                <p class="text-sm font-medium text-gray-500">Histórico de Entradas</p>
                                <a href="{{ route('products.entries', $product->id) }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded mt-2 inline-block">
                                    <i class="fas fa-history mr-1"></i> Ver Entradas
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-8 border-t pt-4">
                <a href="{{ route('products.index') }}" class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">
                    <i class="fas fa-arrow-left mr-1"></i> Voltar para a lista
                </a>
            </div>
        </div>
    </div>
</div>
@endsection