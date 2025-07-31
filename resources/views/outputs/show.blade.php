@extends('layouts.app')

@section('title', 'Detalhes da Saída')

@section('content')
<div class="py-4 sm:py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Cabeçalho -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Detalhes da Saída</h1>
            <a href="{{ route('outputs.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Voltar
            </a>
        </div>

        <!-- Card de Informações -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <div class="p-4 sm:p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">Informações da Saída</h2>
                
                <div class="space-y-3">
                    <div class="flex flex-col sm:flex-row">
                        <span class="text-sm font-medium text-gray-500 sm:w-1/3">Data e Hora:</span>
                        <span class="text-gray-800">{{ $output->output_date->format('d/m/Y H:i') }}</span>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row">
                        <span class="text-sm font-medium text-gray-500 sm:w-1/3">Tipo de Chamado:</span>
                        <span class="text-gray-800 capitalize">{{ str_replace('_', ' ', $output->call_type) }}</span>
                    </div>
                    
                    @if($output->conecta_code)
                    <div class="flex flex-col sm:flex-row">
                        <span class="text-sm font-medium text-gray-500 sm:w-1/3">Código Conecta:</span>
                        <span class="text-gray-800">{{ $output->conecta_code }}</span>
                    </div>
                    @endif
                    
                    <div class="flex flex-col sm:flex-row">
                        <span class="text-sm font-medium text-gray-500 sm:w-1/3">Solicitante:</span>
                        <span class="text-gray-800">{{ $output->caller_name }}</span>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row">
                        <span class="text-sm font-medium text-gray-500 sm:w-1/3">Destino:</span>
                        <span class="text-gray-800">{{ $output->destination }}</span>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row">
                        <span class="text-sm font-medium text-gray-500 sm:w-1/3">Responsável:</span>
                        <span class="text-gray-800">{{ $output->publicServant->name }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card de Produtos -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <div class="p-4 sm:p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">Produtos</h2>
                
                <div class="overflow-x-auto">
                    <!-- Tabela para desktop -->
                    <table class="w-full hidden sm:table">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produto</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantidade</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usada</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Devolvida</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($output->products as $product)
                            <tr>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $product->name }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $product->pivot->quantity }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $product->pivot->quantity_used }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $product->pivot->quantity_returned }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <!-- Lista para mobile -->
                    <div class="sm:hidden space-y-4">
                        @foreach ($output->products as $product)
                        <div class="border rounded-lg p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-medium text-gray-900">{{ $product->name }}</h3>
                                    <div class="mt-2 grid grid-cols-2 gap-2">
                                        <div>
                                            <span class="text-xs text-gray-500">Quantidade</span>
                                            <p class="text-sm">{{ $product->pivot->quantity }}</p>
                                        </div>
                                        <div>
                                            <span class="text-xs text-gray-500">Usada</span>
                                            <p class="text-sm">{{ $product->pivot->quantity_used }}</p>
                                        </div>
                                        <div>
                                            <span class="text-xs text-gray-500">Devolvida</span>
                                            <p class="text-sm">{{ $product->pivot->quantity_returned }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Observações (se existir) -->
        @if($output->observation)
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <div class="p-4 sm:p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Observações</h2>
                <p class="text-gray-700 whitespace-pre-line">{{ $output->observation }}</p>
            </div>
        </div>
        @endif

        <!-- Botões de Ação -->
        <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-2">
            <a href="{{ route('outputs.edit', $output->id) }}" class="inline-flex items-center justify-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Editar
            </a>
            <a href="{{ route('outputs.index') }}" class="inline-flex items-center justify-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Voltar para lista
            </a>
        </div>
    </div>
</div>
@endsection