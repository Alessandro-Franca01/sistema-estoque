@extends('layouts.app')

@section('title', 'Detalhes do Chamado')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-5xl mx-auto">
            <!-- Cabeçalho -->
            <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 px-6 py-5 rounded-t-lg flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-white">Detalhes do Chamado</h1>
                    <p class="mt-1 text-indigo-100 text-sm sm:text-base">Ordem de Serviço: {{ $call->service_order }}</p>
                </div>
                <div class="flex space-x-2">
                    @if (auth()->user()->hasRole('administrativo'))
                    <a href="{{ route('calls.edit', $call) }}" class="inline-flex items-center px-3 py-1 bg-white border border-transparent rounded-md font-medium text-indigo-700 hover:bg-indigo-50 transition-colors duration-200 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.38-2.827-2.828z" />
                        </svg>
                        Editar
                    </a>
                    @endif
                    <a href="{{ route('calls.index') }}" class="inline-flex items-center px-3 py-1 bg-indigo-700 border border-transparent rounded-md font-medium text-white hover:bg-indigo-800 transition-colors duration-200 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Voltar
                    </a>
                </div>
            </div>

            <!-- Card de Detalhes -->
            <div class="bg-white shadow-md rounded-b-lg divide-y divide-gray-200">
                <!-- Informações Básicas -->
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Informações do Chamado</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Tipo</p>
                            <p class="mt-1 text-sm text-gray-900 capitalize">{{ str_replace('_', ' ', $call->type) }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Código de Conexão</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $call->connect_code ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Telefone</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $call->phone ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Solicitante</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $call->applicant ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Informações da Saída -->
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Informações da Saída</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Data da Saída</p>
                            <p class="mt-1 text-sm text-gray-900">
                                @if($call->output)
                                    {{ $call->output->output_date->format('d/m/Y H:i') }}
                                @else
                                    <span class="text-gray-400">N/A</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Status</p>
                            <p class="mt-1 text-sm">
                                @if($call->output)
                                    @php
                                        $statusClasses = [
                                            'pendente' => 'bg-yellow-100 text-yellow-800',
                                            'concluído' => 'bg-green-100 text-green-800',
                                            'cancelado' => 'bg-red-100 text-red-800'
                                        ];
                                        $statusClass = $statusClasses[$call->output->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                        {{ ucfirst($call->output->status) }}
                                    </span>
                                @else
                                    <span class="text-gray-400">N/A</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Responsável</p>
                            <p class="mt-1 text-sm text-gray-900">
                                @if($call->output && $call->output->publicServant)
                                    {{ $call->output->publicServant->name }}
                                @else
                                    <span class="text-gray-400">N/A</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Observação -->
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Observações</h2>
                    <div class="bg-gray-50 p-4 rounded-md">
                        <p class="text-sm text-gray-700 whitespace-pre-line">{{ $call->observation ?? 'Nenhuma observação registrada.' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
