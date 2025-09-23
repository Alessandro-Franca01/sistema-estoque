@extends('layouts.app')

@section('title', 'Lista de Saídas')

@section('content')
    @php
        $user = auth()->user();
        $canCreate = $user?->hasAnyRole(['administrativo', 'almoxarife']);
    @endphp

    <div class="container mx-auto px-4 py-8 mt-4">
        <div class="max-w-7xl mx-auto">
            <!-- Cabeçalho -->
            <div class="bg-gray-800 text-white px-6 py-4 rounded-t-lg flex justify-between items-center">
                <h1 class="text-2xl font-semibold">Registro de Saídas</h1>
                @if($canCreate)
                    <a href="{{ route('outputs.create') }}" class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Novo
                    </a>
                @endif
            </div>

            <!-- Card da Tabela -->
            <div class="bg-white shadow-md rounded-b-lg overflow-hidden">
                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <!-- Tabela para Desktop -->
                    <table class="min-w-full divide-y divide-gray-200 hidden sm:table">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hora</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Responsável</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Observação</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detalhes</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($outputs as $output)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $output->output_date->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $output->output_date->format('H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $output->publicServant->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <button type="button" data-observation="{{ e($output->observation) }}" class="open-observation text-blue-600 hover:text-blue-800 font-medium">
                                        Visualizar
                                    </button>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusClasses = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'completed' => 'bg-green-100 text-green-800',
                                            'canceled' => 'bg-red-100 text-red-800'
                                        ];
                                        $status = [
                                            'pending' => 'pendente',
                                            'completed' => 'concluído',
                                            'canceled' => 'cancelado'
                                        ];
                                        $statusClass = $statusClasses[$output->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                        {{ ucfirst($status[$output->status]) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('outputs.show', $output) }}" class="text-blue-600 hover:text-blue-900" title="Visualizar">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">Nenhuma saída registrada</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <!-- Lista para Mobile - Versão melhorada -->
                    <div class="sm:hidden space-y-3 p-3">
                        @forelse ($outputs as $output)
                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                                <div class="p-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="font-medium text-gray-900">{{ $output->publicServant->name }}</h3>
                                            <p class="text-sm text-gray-500 mt-1">
                                                {{ $output->output_date->format('d/m/Y') }} às {{ $output->output_date->format('H:i') }}
                                            </p>
                                        </div>
                                        @php
                                            $statusClasses = [
                                                'pendente' => 'bg-yellow-100 text-yellow-800',
                                                'concluído' => 'bg-green-100 text-green-800',
                                                'cancelado' => 'bg-red-100 text-red-800'
                                            ];
                                            $status = [
                                                'pending' => 'pendente',
                                                'completed' => 'concluído',
                                                'canceled' => 'cancelado'
                                            ];
                                            $statusClass = $statusClasses[$output->status] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                            {{ ucfirst($status[$output->status]) }}
                                        </span>
                                    </div>

                                    <div class="mt-3 space-y-2 text-sm">
                                        <div class="flex items-start">
                                            <span class="text-gray-500 w-24 flex-shrink-0">Observação:</span>
                                            <button type="button" data-observation="{{ e($output->observation) }}" class="open-observation text-blue-600 hover:text-blue-800 font-medium text-left">
                                                Visualizar
                                            </button>
                                        </div>
                                    </div>

                                    <div class="mt-4 flex justify-end space-x-3">
                                        <a href="{{ route('outputs.show', $output) }}" class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            Detalhes
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden p-4 text-center text-gray-500">
                                Nenhuma saída registrada
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Paginação -->
                @if($outputs->hasPages())
                    <div class="px-4 py-3 bg-gray-50 border-t border-gray-200 sm:px-6">
                        {{ $outputs->links() }}
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
