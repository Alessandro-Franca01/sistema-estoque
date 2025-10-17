@extends('layouts.app')

@section('title', 'Listagem de Servidores Públicos')

@section('content')
    @php
        $canAdmin = auth()->user()->hasRole('administrativo');
    @endphp

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-6xl mx-auto">
            <!-- Cabeçalho -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-5 rounded-t-lg flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-white">Servidores Públicos</h1>
                    <p class="mt-1 text-blue-100 text-sm sm:text-base">Lista completa de servidores cadastrados</p>
                </div>
                <div class="w-full sm:w-auto">
                    <a href="{{ route('public_servants.create') }}"
                       class="w-full sm:w-auto flex items-center justify-center px-4 py-2 bg-white border border-transparent rounded-md font-medium text-blue-700 hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                        </svg>
                        Novo Servidor
                    </a>
                </div>
            </div>

            <!-- Mensagem de Sucesso -->
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-6 py-8" role="alert">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Card da Tabela -->
            <div class="bg-white shadow-md rounded-b-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Matrícula</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CPF</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Empresa</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Função</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acesso</th>
                            @if($canAdmin)
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($servants as $servant)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="text-sm font-medium text-gray-900">{{ $servant->name }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ customMask($servant->registration, '##.###-#') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ !empty($servant->cpf)  ? formatDocument($servant->cpf) : 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $typeClass = match($servant->servant_type) {
                                            'EFETIVO' => 'bg-blue-100 text-blue-800',
                                            'COMISSIONADO' => 'bg-purple-100 text-purple-800',
                                            'TERCEIRIZADO' => 'bg-green-100 text-green-800',
                                            default => 'bg-gray-100 text-gray-800',
                                        };
                                    @endphp
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $typeClass }}">
                                        {{ $servant->servant_type }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $servant->servant_type === 'TERCEIRIZADO' ? ($servant->outsourced_company ?? '—') : 'N/A' }}
                                </td>
                                @php
                                    $dept = $servant->departments->first();
                                    $jobFunction = $dept?->pivot?->job_function;
                                    $isActivePivot = (bool) ($dept?->pivot?->is_active);
                                    $jobClass = match($jobFunction) {
                                        'ADMINISTRADOR' => 'bg-yellow-100 text-yellow-800',
                                        'ALMOXARIFE' => 'bg-purple-100 text-purple-800',
                                        'OPERADOR' => 'bg-blue-100 text-blue-800',
                                        'SERVIDOR' => 'bg-gray-100 text-gray-800',
                                        default => 'bg-gray-100 text-gray-800',
                                    };
                                @endphp
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $jobClass }}">
                                        {{ $jobFunction ?? '—' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $isActivePivot ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $isActivePivot ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ !empty($servant->user_id) ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ !empty($servant->user_id)  ? 'SIM' : 'NÃO' }}
                                    </span>
                                </td>
                                @if($canAdmin)
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('public_servants.edit', $servant->id) }}" class="text-blue-600 hover:text-blue-900" title="Editar">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </a>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $canAdmin ? 6 : 5 }}" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Nenhum servidor cadastrado
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginação -->
                @if($servants->hasPages())
                    <div class="px-4 py-3 bg-gray-50 border-t border-gray-200 sm:px-6">
                        {{ $servants->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
