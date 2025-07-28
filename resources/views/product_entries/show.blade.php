@extends('layouts.app')

@section('title', 'Detalhes da Entrada de Produto')

@section('content')
<div class="container mx-auto px-4 py-8 mt-4">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gray-800 text-white px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-semibold">Detalhes da Entrada #{{ $productEntry->id }}</h1>
            <div class="flex space-x-2">
                <a href="{{ route('product_entries.edit', $productEntry->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-edit mr-1"></i> Editar
                </a>
                <form action="{{ route('product_entries.destroy', $productEntry->id) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir esta entrada?')">
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
                <!-- Coluna 1: Informações da Entrada -->
                <div class="space-y-4">
                    <div class="border-b pb-4">
                        <h2 class="text-xl font-semibold mb-4 text-gray-800">Informações da Entrada</h2>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Data de Entrada</p>
                                <p class="text-base font-medium">{{ $productEntry->entry_date->format('d/m/Y') }}</p>
                            </div>
                            
                            <div>
                                <p class="text-sm font-medium text-gray-500">Nota Fiscal</p>
                                <p class="text-base font-medium">{{ $productEntry->invoice_number ?: 'N/A' }}</p>
                            </div>
                            
                            <div>
                                <p class="text-sm font-medium text-gray-500">Quantidade</p>
                                <p class="text-base font-medium">{{ $productEntry->quantity }}</p>
                            </div>
                            
                            <div>
                                <p class="text-sm font-medium text-gray-500">Custo Unitário</p>
                                <p class="text-base font-medium">R$ {{ number_format($productEntry->unit_cost, 2, ',', '.') }}</p>
                            </div>
                            
                            <div class="col-span-2">
                                <p class="text-sm font-medium text-gray-500">Custo Total</p>
                                <p class="text-lg font-bold text-blue-600">R$ {{ number_format($productEntry->total_cost, 2, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Observações -->
                    <div>
                        <h3 class="text-lg font-semibold mb-2 text-gray-800">Observações</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-gray-700">{{ $productEntry->notes ?: 'Nenhuma observação registrada.' }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Coluna 2: Informações do Produto e Fornecedor -->
                <div class="space-y-4">
                    <!-- Produto -->
                    <div class="border-b pb-4">
                        <h2 class="text-xl font-semibold mb-4 text-gray-800">Informações do Produto</h2>
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <div class="flex items-center mb-2">
                                <span class="text-lg font-bold text-blue-800">{{ $productEntry->product->name }}</span>
                                <span class="ml-2 px-2 py-1 bg-blue-200 text-blue-800 text-xs rounded-full">{{ $productEntry->product->code }}</span>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-2 mt-3">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Categoria</p>
                                    <p class="text-base">{{ $productEntry->product->category->name }}</p>
                                </div>
                                
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Preço de Venda</p>
                                    <p class="text-base">R$ {{ number_format($productEntry->product->price, 2, ',', '.') }}</p>
                                </div>
                                
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Estoque Atual</p>
                                    <p class="text-base font-medium">{{ $productEntry->product->stock_quantity }} unidades</p>
                                </div>
                                
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Status</p>
                                    <p class="text-base">
                                        @if($productEntry->product->is_active)
                                            <span class="px-2 py-1 bg-green-200 text-green-800 rounded-full text-xs">Ativo</span>
                                        @else
                                            <span class="px-2 py-1 bg-red-200 text-red-800 rounded-full text-xs">Inativo</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            
                            <div class="mt-3">
                                <a href="{{ route('products.show', $productEntry->product->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    <i class="fas fa-external-link-alt mr-1"></i> Ver detalhes do produto
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Fornecedor -->
                    <div>
                        <h2 class="text-xl font-semibold mb-4 text-gray-800">Informações do Fornecedor</h2>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <div class="flex items-center mb-2">
                                <span class="text-lg font-bold text-green-800">{{ $productEntry->supplier->company_name }}</span>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-2 mt-3">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Nome Fantasia</p>
                                    <p class="text-base">{{ $productEntry->supplier->trade_name }}</p>
                                </div>
                                
                                <div>
                                    <p class="text-sm font-medium text-gray-500">CNPJ</p>
                                    <p class="text-base">{{ $productEntry->supplier->cnpj }}</p>
                                </div>
                                
                                <div class="col-span-2">
                                    <p class="text-sm font-medium text-gray-500">Contato</p>
                                    <p class="text-base">{{ $productEntry->supplier->email }} | {{ $productEntry->supplier->phone }}</p>
                                </div>
                            </div>
                            
                            <div class="mt-3">
                                <a href="{{ route('suppliers.show', $productEntry->supplier->id) }}" class="text-green-600 hover:text-green-800 text-sm font-medium">
                                    <i class="fas fa-external-link-alt mr-1"></i> Ver detalhes do fornecedor
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-8 border-t pt-4">
                <a href="{{ route('product_entries.index') }}" class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">
                    <i class="fas fa-arrow-left mr-1"></i> Voltar para a lista
                </a>
            </div>
        </div>
    </div>
</div>
@endsection