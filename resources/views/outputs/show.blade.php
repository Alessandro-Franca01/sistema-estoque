@extends('layouts.app')

@section('title', 'Detalhes da Saída')

@section('content')
<div class="py-4 sm:py-6">
    <div class="max-w-7xl px-4 sm:px-6 lg:px-8">
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

        <!-- Card de Informações -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <div class="p-4 sm:p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">Informações da Saída</h2>

                <div class="space-y-3">
                    <div class="flex flex-col sm:flex-row">
                        <span class="text-sm font-medium text-gray-500 sm:w-1/3">Data:</span>
                        <span class="text-gray-800">{{ $output->output_date->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex flex-col sm:flex-row">
                        <span class="text-sm font-medium text-gray-500 sm:w-1/3">Hora:</span>
                        <span class="text-gray-800">{{ $output->output_date->format('H:i') }}</span>
                    </div>
                    <div class="flex flex-col sm:flex-row">
                        <span class="text-sm font-medium text-gray-500 sm:w-1/3">Status:</span>
                        <span id-="status" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                            {{ ucfirst($status[$output->status]) }}
                        </span>
                    </div>
                    <div class="flex flex-col sm:flex-row">
                        <span class="text-sm font-medium text-gray-500 sm:w-1/3">Responsável:</span>
                        <span class="text-gray-800">{{ $output->publicServant->name }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card de Produtos Editável -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <div class="p-4 sm:p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">Produtos</h2>
                <form id="productsForm" method="POST" action="{{ route('output.finish', ['output' => $output->id]) }}">
                    @csrf
                    @method('PUT')

                    <div class="overflow-x-auto">
                        <table class="w-full min-w-full border rounded-lg">
                            <thead class="bg-gray-100">
                            <tr class="text-left text-sm font-semibold text-gray-700">
                                <th class="px-3 py-2">Produto</th>
                                <th class="px-3 py-2">Retirado</th>
                                <th class="px-3 py-2">Usada</th>
                                <th class="px-3 py-2">Devolvida</th>
                                <th class="px-3 py-2">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($output->products as $index => $product)
                                <tr class="border-t product-row" data-total="{{ $product->pivot->quantity }}">
                                    <td class="px-3 py-2 text-sm text-gray-900">
                                        {{ $product->name }}
                                        <input type="hidden" name="products[{{$index}}][id]" value="{{ $product->id }}">
                                    </td>
                                    <td class="px-3 py-2 text-sm text-gray-600">
                                        {{ $product->pivot->quantity }}
                                    </td>
                                    <td class="px-3 py-2">
                                        <input
                                            type="number"
                                            name="products[{{$index}}][quantity_used]"
                                            value="{{ $product->pivot->quantity_used }}"
                                            class="quantity-used w-full px-2 py-1 border border-gray-300 rounded-md text-sm shadow-sm focus:ring focus:ring-indigo-300"
                                            min="0"
                                            max="{{ $product->pivot->quantity }}"
                                            data-product-id="{{ $product->id }}">
                                    </td>
                                    <td class="px-3 py-2">
                                        <input
                                            type="number"
                                            name="products[{{$index}}][quantity_returned]"
                                            value="{{ $product->pivot->quantity_returned }}"
                                            class="quantity-returned w-full px-2 py-1 border border-gray-300 rounded-md text-sm shadow-sm focus:ring focus:ring-indigo-300"
                                            min="0"
                                            max="{{ $product->pivot->quantity }}"
                                            data-product-id="{{ $product->id }}">
                                    </td>
                                    <td class="px-3 py-2 text-sm">
                                        <span class="quantity-status text-xs font-medium text-gray-600"></span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Mensagem de erro -->
                    <div class="mt-6 text-red-500 text-sm hidden" id="formError">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>

                        <span id="errorMessage">A soma das quantidades usadas e devolvidas deve ser igual à quantidade retirada para todos os produtos.</span>
                    </div>
                    @if(!$output->status === 'completed')
                    <!-- Botão de envio -->
                    <div class="mt-6 flex justify-between items-center">
                        <button type="submit" id="submitButton"
                                class="inline-flex items-center px-4 py-2 bg-gray-400 border border-transparent rounded-md font-semibold text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                                disabled>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Atualizar Produtos
                        </button>
                    </div>
                    @endif
                </form>
            </div>
        </div>
        @endsection

        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const form = document.getElementById('productsForm');
                    const submitButton = document.getElementById('submitButton');
                    const formError = document.getElementById('formError');
                    const errorMessage = document.getElementById('errorMessage');

                    // Função para validar uma linha individual
                    // TODO: Erro está aqui, FOREACH está interando mais do que a quantidade de produtos
                    function validateRow(row) {
                        const total = parseInt(row.dataset.total);
                        const usedInput = row.querySelector('.quantity-used');
                        const returnedInput = row.querySelector('.quantity-returned');
                        const statusElement = row.querySelector('.quantity-status') || row.querySelector('.quantity-status-mobile');

                        let used = parseInt(usedInput.value) || 0;
                        let returned = parseInt(returnedInput.value) || 0;

                        // Validar valores negativos
                        if (used < 0 || returned < 0) {
                            if (used < 0) {
                                usedInput.value = 0;
                                used = 0;
                            }
                            if (returned < 0) {
                                returnedInput.value = 0;
                                returned = 0;
                            }
                        }

                        // Validar soma
                        const sum = used + returned;
                        const isValid = sum === total && used >= 0 && returned >= 0;

                        // Atualizar status
                        if (statusElement) {
                            if (used < 0 || returned < 0) {
                                statusElement.textContent = 'Valor não pode ser negativo';
                                statusElement.classList.add('text-red-500');
                                statusElement.classList.remove('text-green-500');
                            } else if (sum !== total) {
                                statusElement.textContent = `Soma deve ser ${total}`;
                                statusElement.classList.add('text-red-500');
                                statusElement.classList.remove('text-green-500');
                            } else {
                                statusElement.textContent = '✔';
                                statusElement.classList.remove('text-red-500');
                                statusElement.classList.add('text-green-500');
                            }
                        }
                        // console.log('total row: '+ total)
                        // console.log('Row valido? ' + isValid);

                        return isValid;
                    }

                    // Função para validar todas as linhas
                    function validateAllRows() {
                        let allValid = true;
                        const rows = document.querySelectorAll('.product-row');
                        let count = 0;

                        rows.forEach(row => {
                            console.log('contando: ' + count);
                            console.log(row);
                            // TODO: Não está funcionando:
                            //  Por que o valor está pegando 4 iteraveis e são tem 2 corretos e 2 sempre estão dando erro
                            // console.log(validateRow(row));
                            if (!validateRow(row)) {
                                allValid = false;
                            }
                            count =+ 1;
                        });

                        return allValid;
                    }

                    // Função para atualizar o estado do botão
                    function updateSubmitButton() {
                        const isValid = validateAllRows();
                        // console.log('É tudo valido? ' + isValid);
                        submitButton.disabled = !isValid;
                        formError.classList.toggle('hidden', isValid);

                        if (isValid) {
                            // alert('todos os produtos estão validaos')
                            submitButton.classList.remove('bg-gray-400');
                            submitButton.classList.add('bg-indigo-600', 'hover:bg-indigo-700');
                            submitButton.disable = false;
                        } else {
                            submitButton.classList.add('bg-gray-400');
                            submitButton.classList.remove('bg-indigo-600', 'hover:bg-indigo-700');
                        }
                    }

                    // Validar ao alterar qualquer input
                    document.querySelectorAll('.quantity-used, .quantity-returned').forEach(input => {
                        input.addEventListener('input', function() {
                            const row = this.closest('.product-row');
                            const total = parseInt(row.dataset.total);
                            const usedInput = row.querySelector('.quantity-used');
                            const returnedInput = row.querySelector('.quantity-returned');

                            let used = parseInt(usedInput.value) || 0;
                            let returned = parseInt(returnedInput.value) || 0;
                            // console.log(row)
                            console.log('retirados: ' + row.dataset.total)
                            console.log('usados, retornados: '+used, returned)

                            // Corrigir valores negativos
                            if (used < 0) {
                                usedInput.value = 0;
                                used = 0;
                            }
                            if (returned < 0) {
                                returnedInput.value = 0;
                                returned = 0;
                            }

                            // Ajustar valores se a soma ultrapassar o total
                            if (used + returned > total) {
                                if (this === usedInput) {
                                    returned = total - used;
                                    returnedInput.value = returned;
                                } else {
                                    used = total - returned;
                                    usedInput.value = used;
                                }
                            }

                            // Atualizar max para os campos
                            usedInput.max = total - returned;
                            returnedInput.max = total - used;

                            updateSubmitButton();
                        });

                        // Validar também quando o campo perde o foco (blur)
                        input.addEventListener('blur', function() {
                            const row = this.closest('.product-row');
                            validateRow(row);
                            updateSubmitButton();
                        });
                    });

                    // Validar antes de enviar o formulário
                    form.addEventListener('submit', function(e) {
                        if (!validateAllRows()) {
                            e.preventDefault();
                            formError.classList.remove('hidden');
                            errorMessage.textContent = 'Verifique os valores. Quantidades não podem ser negativas e a soma deve ser igual à quantidade retirada.';
                        }
                        document.addEventListener('DOMContentLoaded', function () {
                            // Desativa inputs duplicados
                            if (window.innerWidth < 640) { // mobile
                                document.querySelectorAll('tr.product-row input').forEach(input => input.disabled = true);
                            } else {
                                document.querySelectorAll('.sm\\:hidden input').forEach(input => input.disabled = true);
                            }
                        });
                    });

                    // Validar inicialmente
                    updateSubmitButton();
                });
            </script>
@endpush
