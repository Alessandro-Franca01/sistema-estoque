@extends('layouts.app')

@section('title', 'Editar Chamados')

@section('content')
<div class="container mx-auto px-4 py-8 mt-4">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Cabeçalho -->
        <div class="bg-gray-800 text-white px-6 py-4">
            <h1 class="text-2xl font-bold text-white">Editar Chamado</h1>
            <p class="mt-1 text-indigo-100">Atualize os campos abaixo para editar o chamado</p>
        </div>

        <!-- Formulário -->
        <div class="px-8 py-8 space-y-6">
            <form method="POST" action="{{ route('calls.update', $call) }}" class="space-y-6">
                @csrf
                @method('PATCH')

                <!-- Grid de campos -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tipo -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700">
                            Tipo <span class="text-red-500">*</span>
                        </label>
                        <select id="type" name="type" required class="mt-1 block w-full py-2 px-3 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('type') border-red-300 text-red-900 @enderror">
                            <option value="">Selecione o tipo</option>
                            <option value="whatssap" {{ old('type', $call->type) == 'whatssap' ? 'selected' : '' }}>WhatsApp</option>
                            <option value="phone" {{ old('type', $call->type) == 'phone' ? 'selected' : '' }}>Telefone</option>
                            <option value="conectar_cabedelo" {{ old('type', $call->type) == 'conectar_cabedelo' ? 'selected' : '' }}>Conecta App</option>
                            <option value="personally" {{ old('type', $call->type) == 'personally' ? 'selected' : '' }}>Pessoalmente</option>
                            <option value="other" {{ old('type', $call->type) == 'other' ? 'selected' : '' }}>Outro</option>
                        </select>
                        @error('type')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <input type="hidden" name="status" value="{{ old('status', $call->status) }}">

                    <!-- Ordem de Serviço -->
                    <div>
                        <label for="service_order" class="block text-sm font-medium text-gray-700">
                            Ordem de Serviço
                        </label>
                        <input type="text" id="service_order" name="service_order" value="{{ old('service_order', $call->service_order) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('service_order') border-red-300 text-red-900 @enderror"
                               placeholder="Número da OS">
                        @error('service_order')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Código de Conexão -->
                    <div>
                        <label for="connect_code" class="block text-sm font-medium text-gray-700">
                            Código Conecta Cabedelo
                        </label>
                        <input type="text" id="connect_code" name="connect_code" value="{{ old('connect_code', $call->connect_code) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('connect_code') border-red-300 text-red-900 @enderror"
                               placeholder="Código do cliente">
                        @error('connect_code')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Telefone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">
                            Telefone
                        </label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $call->phone) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('phone') border-red-300 text-red-900 @enderror"
                               placeholder="(00) 00000-0000">
                        @error('phone')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nome do Solicitante -->
                    <div>
                        <label for="applicant" class="block text-sm font-medium text-gray-700">
                            Nome do Solicitante
                        </label>
                        <input type="text" id="applicant" name="applicant" value="{{ old('applicant', $call->applicant) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('applicant') border-red-300 text-red-900 @enderror"
                               placeholder="Nome completo">
                        @error('applicant')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Saída -->
                    <div>
                        <label for="output_id" class="block text-sm font-medium text-gray-700">
                            Saída
                        </label>
                        <select id="output_id" name="output_id"
                                class="mt-1 block w-full py-2 px-3 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('output_id') border-red-300 text-red-900 @enderror">
                            <option value="">Selecione a Saída</option>
                            @foreach($outputs as $output)
                                <option value="{{ $output->id }}" {{ (string)old('output_id', $call->output_id) === (string)$output->id ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::parse($output->output_date)->format('d/m/Y H:i') }}
                                </option>
                            @endforeach
                        </select>
                        @error('output_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- CEP -->
                    <div>
                        <label for="cep" class="block text-sm font-medium text-gray-700">
                            CEP
                        </label>
                        <input type="text" id="cep" name="cep" value="{{ old('cep', $call->cep) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('cep') border-red-300 text-red-900 @enderror"
                               placeholder="CEP">
                        @error('cep')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Complemento -->
                    <div>
                        <label for="complement" class="block text-sm font-medium text-gray-700">
                            Complemento
                        </label>
                        <input type="text" id="complement" name="complement" value="{{ old('complement', $call->complement) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('complement') border-red-300 text-red-900 @enderror"
                               placeholder="Complemento">
                        @error('complement')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Destino -->
                <div>
                    <label for="destination" class="block text-sm font-medium text-gray-700">
                        Destino / Local
                    </label>
                    <input type="text" id="destination" name="destination" value="{{ old('destination', $call->destination) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('destination') border-red-300 text-red-900 @enderror"
                           placeholder="Destino">
                    @error('destination')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Observações -->
                <div>
                    <label for="observation" class="block text-sm font-medium text-gray-700">
                        Observações
                    </label>
                    <div class="mt-1">
                        <textarea id="observation" name="observation" rows="4"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('observation') border-red-300 text-red-900 @enderror"
                                  placeholder="Descreva detalhes relevantes sobre o chamado">{{ old('observation', $call->observation) }}</textarea>
                    </div>
                    @error('observation')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Ações -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Voltar
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-500 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Atualizar Chamado
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cepInput = document.getElementById('cep');
        const destinationInput = document.getElementById('destination');
        const complementInput = document.getElementById('complement');

        if (!cepInput) return;

        function sanitizeCep(value) {
            return (value || '').replace(/\D/g, '').slice(0, 8);
        }

        async function fetchCep(cep) {
            try {
                const res = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
                if (!res.ok) return null;
                const data = await res.json();
                if (data && !data.erro) return data;
            } catch (e) {
                console.warn('Erro ao buscar CEP:', e);
            }
            return null;
        }

        function buildDestination(data) {
            const parts = [];
            if (data.logradouro) parts.push(data.logradouro);
            if (data.bairro) parts.push(data.bairro);
            const cityState = [data.localidade, data.uf].filter(Boolean).join(' - ');
            if (cityState) parts.push(cityState);
            return parts.join(', ');
        }

        async function handleCepLookup() {
            const cep = sanitizeCep(cepInput.value);
            if (cep.length !== 8) return; // CEP inválido/incompleto

            // Indicar carregamento simples
            const prev = destinationInput ? destinationInput.value : '';
            if (destinationInput && !destinationInput.value) destinationInput.placeholder = 'Buscando endereço...';

            const data = await fetchCep(cep);
            if (!data) {
                if (destinationInput && destinationInput.placeholder === 'Buscando endereço...') destinationInput.placeholder = '';
                return;
            }

            // Preenche destino formatado
            if (destinationInput) {
                const formatted = buildDestination(data);
                if (formatted) destinationInput.value = formatted;
                destinationInput.placeholder = '';
            }

            // Preenche complemento se vier algo e o campo estiver vazio
            if (complementInput && !complementInput.value && data.complemento) {
                complementInput.value = data.complemento;
            }
        }

        // Dispara busca ao sair do campo CEP
        cepInput.addEventListener('blur', handleCepLookup);

        // Opcional: ao digitar 8 dígitos, já busca
        cepInput.addEventListener('input', function () {
            const val = sanitizeCep(cepInput.value);
            if (val.length === 8) handleCepLookup();
        });
    });
</script>
@endsection
