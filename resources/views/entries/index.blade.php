@extends('layouts.app')

@section('title', 'Listagem de Entradas')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('entries.create') }}" class="btn btn-primary bg-blue-500 text-white px-4 py-2 rounded-md">Adicionar Entrada</a>
                    </div>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fornecedor</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data de Entrada</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Número da Nota Fiscal</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Observação</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($entries as $entry)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $entry->supplier->trade_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $entry->entry_date }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $entry->invoice_number }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($entry->observation)
                                            <button onclick="showObservationModal('{{ addslashes($entry->observation) }}')"
                                                    class="text-blue-600 hover:text-blue-900 underline cursor-pointer">
                                                Visualizar
                                            </button>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <a href="{{ route('entries.show', $entry) }}" class="text-blue-600 hover:text-blue-900 mr-2">Ver</a>
                                        <a href="{{ route('entries.edit', $entry) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">Editar</a>
                                        <form action="{{ route('entries.destroy', $entry) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Excluir</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $entries->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Observação -->
    <div id="observationModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Observação Completa</h3>
                    <div id="modalObservationContent" class="mt-2 max-h-96 overflow-y-auto">
                        <!-- Conteúdo da observação será inserido aqui -->
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" onclick="closeObservationModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Fechar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
            function showObservationModal(observation) {
                document.getElementById('modalObservationContent').textContent = observation;
                document.getElementById('observationModal').classList.remove('hidden');
            }

            function closeObservationModal() {
                document.getElementById('observationModal').classList.add('hidden');
            }

            // Fechar modal ao clicar fora do conteúdo
            document.getElementById('observationModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeObservationModal();
                }
            });

            // Fechar modal com tecla ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeObservationModal();
                }
            });
    </script>
@endsection
