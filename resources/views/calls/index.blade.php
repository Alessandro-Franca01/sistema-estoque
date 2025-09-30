@extends('layouts.app')

@section('title', 'Lista de Chamados')

@section('content')
    @php
        $user = auth()->user();
        $canAdmin = $user?->hasRole('administrativo');
    @endphp
<div class="min-h-screen py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-black shadow-xl rounded-lg overflow-hidden">
            <!-- Cabeçalho -->
            <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 px-4 sm:px-6 py-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-white">Lista de Chamados</h1>
                    <p class="mt-1 text-indigo-100 text-sm sm:text-base">Visualize e gerencie todos os chamados registrados</p>
                </div>
                <div class="w-full sm:w-auto">
                    <a href="{{ route('calls.create') }}"
                       class="w-full sm:w-auto flex items-center justify-center sm:justify-start px-3 py-2 sm:px-4 sm:py-2 bg-white border border-transparent rounded-md font-medium text-indigo-700 hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white transition-colors duration-200 text-sm sm:text-base">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 mr-1 sm:mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                        </svg>
                        <span class="truncate">Novo Chamado</span>
                    </a>
                </div>
            </div>

                <!-- Filtros e Busca -->
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <form method="GET" action="{{ route('calls.index') }}" class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                            <label for="search" class="sr-only">Buscar</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" name="search" id="search" value="{{ request('search') }}"
                                       class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md"
                                       placeholder="Buscar por nome, telefone...">
                            </div>
                        </div>
                        <div>
                            <label for="type" class="sr-only">Tipo</label>
                            <select id="type" name="type" onchange="this.form.submit()"
                                    class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="">Todos os tipos</option>
                                <option value="whatssap" @if(request('type')=='Suporte') selected @endif>Whatssap</option>
                                <option value="conectar_cabedelo" @if(request('type')=='Incidente') selected @endif>Conectar Cabedelo</option>
                                <option value="personally" @if(request('type')=='Solicitação') selected @endif>Pessoalmente</option>
                                <option value="phone" @if(request('type')=='Solicitação') selected @endif>Telefone</option>
                                <option value="other" @if(request('type')=='Solicitação') selected @endif>Outro</option>
                            </select>
                        </div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Filtrar
                        </button>
                    </form>
                    <!-- Mensagem de sucesso -->
                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif
                </div>

                <!-- Tabela de Chamados -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'type', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center">
                                        Tipo
                                        @if(request('sort') == 'type')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        @endif
                                    </a>
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Solicitante
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Telefone
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Destino
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    CEP
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($calls as $call)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if($call->type == 'Incidente') bg-red-100 text-red-800
                                            @elseif($call->type == 'Suporte') bg-blue-100 text-blue-800
                                            @else bg-blue-100 text-blue-800 @endif">
                                            {{ $call->type }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $call->applicant }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ formatPhone($call->phone) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $call->destination }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ formatCep($call->cep) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($call->status)
                                            @php
                                                $statusClasses = [
                                                    'in_progress' => 'bg-yellow-100 text-yellow-800',
                                                    'finished' => 'bg-green-100 text-green-800',
                                                    'canceled' => 'bg-red-100 text-red-800'
                                                ];
                                                $status = [
                                                    'in_progress' => 'em andamento',
                                                    'finished' => 'finalizado',
                                                    'canceled' => 'cancelado'
                                                ];
                                                $statusClass = $statusClasses[$call->status] ?? 'bg-gray-100 text-gray-800';
                                            @endphp
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                                {{ ucfirst($status[$call->status]) }}
                                            </span>
                                       @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('calls.show', $call) }}" class="text-indigo-600 hover:text-indigo-900" title="Visualizar">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                            @if($canAdmin && $call->status == 'in_progress')
                                            <a href="{{ route('calls.edit', $call) }}" class="text-yellow-600 hover:text-yellow-900" title="Editar">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                </svg>
                                            </a>

                                            <form action="{{ route('calls.cancel', $call) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="text-red-600 hover:text-red-900" title="Cancelar" onclick="return confirm('Tem certeza que deseja cancelar este chamado? Isso não poderá ser desfeito.')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                                                    </svg>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                        Nenhum chamado encontrado.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginação -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    {{ $calls->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
