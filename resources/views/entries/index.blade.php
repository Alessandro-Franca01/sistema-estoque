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
                    Nova Entrada
                </a>
                @endif
            </div>

            <div class="flex flex-col items-center overflow-x-auto">
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if ($entries->isEmpty())
                    <p class="text-gray-600">Nenhuma entrada cadastrada ainda.</p>
                @else
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
{{--                                        <button onclick="showObservationModal('{{ addslashes($entry->observation) }}')"--}}
{{--                                                class="text-blue-600 hover:text-blue-900 underline cursor-pointer">--}}
{{--                                            Visualizar--}}
{{--                                        </button>--}}
                                        <button type="button" data-observation="{{ e($entry->observation) }}" class="open-observation text-blue-600 hover:text-blue-800 font-medium">
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
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $entries->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal de Observação - Versão melhorada -->
    <div id="observation-modal" class="fixed inset-0 z-50 hidden" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-0">
            <div class="relative w-full max-w-lg transform rounded-lg bg-white text-left shadow-xl transition-all">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                            <h3 class="text-lg font-semibold leading-6 text-gray-900">Observação</h3>
                            <div class="mt-4">
                                <div class="bg-gray-50 p-4 rounded-md max-h-96 overflow-y-auto">
                                    <p id="observation-content" class="text-gray-700 whitespace-pre-line"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button" id="close-observation" class="inline-flex w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 sm:ml-3 sm:w-auto">
                        Fechar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('observation-modal');
            const content = document.getElementById('observation-content');
            const closeBtn = document.getElementById('close-observation');
            const backdrop = modal.querySelector('.bg-gray-500');

            function openModal(text) {
                content.textContent = text && text.trim() ? text : 'Nenhuma observação registrada.';
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            function closeModal() {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }

            // Abrir modal ao clicar em qualquer botão com classe open-observation
            document.addEventListener('click', function(e) {
                const trigger = e.target.closest('.open-observation');
                if (trigger) {
                    e.preventDefault();
                    const obs = trigger.getAttribute('data-observation') || '';
                    openModal(obs);
                }
            });

            // Fechar modal
            closeBtn?.addEventListener('click', closeModal);
            backdrop?.addEventListener('click', closeModal);

            // Fechar com ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                    closeModal();
                }
            });
        });
    </script>
@endsection
