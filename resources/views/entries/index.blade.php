@extends('layouts.app')

@section('title', 'Listagem de Entradas')

@section('content')
    @php
        $user = auth()->user();
        $canAdmin = $user?->hasRole('administrativo');
    @endphp

    <div class="container mx-auto px-4 py-8 mt-4">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gray-800 text-white px-6 py-4 flex justify-between items-center">
                <h1 class="text-2xl font-semibold">Entradas</h1>
                @if (auth()->user()->hasRole('administrativo'))
                <a href="{{ route('entries.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Adicionar Entrada
                </a>
                @endif
            </div>

            <div class="p-6">
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if ($entries->isEmpty())
                    <p class="text-gray-600">Nenhuma entrada cadastrada ainda.</p>
                @else
                    <div class="overflow-x-auto">
                        <div class="inline-block min-w-full align-middle">
                            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                    <tr>
                                        <th class="px-4 py-2">Fornecedor</th>
                                        <th class="px-4 py-2">Tipo</th>
                                        <th class="px-4 py-2">Data de Entrada</th>
                                        <th class="px-4 py-2">Nota Fiscal</th>
                                        <th class="px-4 py-2">Observação</th>
                                        <th class="px-4 py-2">Ações</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($entries as $entry)
                                        <tr>
                                            <td class="px-4 py-2">
                                                <p class="text-gray-900 whitespace-no-wrap">{{ $entry->supplier->trade_name ?? 'Sem Fornecedor' }}</p>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                @php
                                                    $types = ['purchased' => 'Compra', 'feeding' => 'Alimentação', 'reversal' => 'Estorno'];
                                                    $classes =
                                                        [
                                                            'purchased' => '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-300">Compra</span>',
                                                            'feeding' => '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-300">Alimentação</span>',
                                                            'reversal' => '<span class="px-6 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-300">Estorno</span>',                                                        ];
                                                @endphp
                                                <span class="{{ $classes[$entry->entry_type] ?? $classes[$entry->entry_type] }}">{{ $types[$entry->entry_type] ?? $types[$entry->entry_type] }}</span>
                                            </td>
                                            <td class="px-4 py-2">
                                                <p class="text-gray-900 whitespace-no-wrap">{{ $entry->entry_date->format('d/m/Y') }}</p>
                                            </td>
                                            <td class="px-4 py-2">
                                                <p class="text-gray-900 whitespace-no-wrap">{{ $entry->invoice_number ?? 'Sem Nota Fiscal' }}</p>
                                            </td>
                                            <td class="px-4 py-2">
                                                @if($entry->observation)
                                                    <button onclick="showObservationModal('{{ addslashes($entry->observation) }}')"
                                                            class="text-blue-600 hover:text-blue-900 underline cursor-pointer">
                                                        Visualizar
                                                    </button>
                                                @else
                                                    <p class="text-gray-900 whitespace-no-wrap"> Sem Observação</p>
                                                @endif
                                            </td>
                                            <td class="px-4 py-2 text-center">
                                                <a href="{{ route('entries.show', $entry) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                                    </svg>
                                                </a>
{{--                                                TODO: REMOVER ESSE BOTÃO DE EDiÇÃO--}}
{{--                                                @if($canAdmin)--}}
{{--                                                    <a href="{{ route('entries.edit', $entry) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">--}}
{{--                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">--}}
{{--                                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.38-2.827-2.828z" />--}}
{{--                                                        </svg>--}}
{{--                                                    </a>--}}
{{--                                                @endif--}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        {{ $entries->links() }}
                    </div>
                @endif
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
