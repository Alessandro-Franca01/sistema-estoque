@extends('layouts.app')

@section('title', 'Cadastrar Nova Secretaria')

@section('content')
<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <!-- Cabeçalho -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-5">
                <h1 class="text-2xl font-bold text-white">Cadastrar Nova Secretaria</h1>
                <p class="mt-1 text-blue-100">Preencha os campos abaixo para registrar uma nova secretaria</p>
            </div>

            <!-- Formulário -->
            <div class="px-6 py-8 space-y-6">
                <form method="POST" action="{{ route('departments.store') }}" class="space-y-6">
                    @csrf

                    <!-- Nome da Secretaria -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">
                            Nome da Secretaria <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-3 pr-10 py-3 sm:text-sm border-gray-300 rounded-md @error('name') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror"
                                placeholder="Ex: Secretaria Municipal de Saúde">
                            @error('name')
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @enderror
                        </div>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sigla e CEP -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Sigla -->
                        <div>
                            <label for="sigla" class="block text-sm font-medium text-gray-700">
                                Sigla <span class="text-red-500">*</span>
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="text" id="sigla" name="sigla" value="{{ old('sigla') }}" required
                                    class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-3 pr-10 py-3 sm:text-sm border-gray-300 rounded-md @error('sigla') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror"
                                    placeholder="Ex: SMS">
                                @error('sigla')
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                @enderror
                            </div>
                            @error('sigla')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- CEP -->
                        <div>
                            <label for="cep" class="block text-sm font-medium text-gray-700">
                                CEP <span class="text-red-500">*</span>
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="text" id="cep" name="cep" value="{{ old('cep') }}" required
                                    class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-3 pr-10 py-3 sm:text-sm border-gray-300 rounded-md @error('cep') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror"
                                    placeholder="00000-000">
                                @error('cep')
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                @enderror
                            </div>
                            @error('cep')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Endereço e Número -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Endereço -->
                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700">
                                Endereço <span class="text-red-500">*</span>
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="text" id="address" name="address" value="{{ old('address') }}" required
                                    class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-3 pr-10 py-3 sm:text-sm border-gray-300 rounded-md @error('address') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror"
                                    placeholder="Rua, Avenida, etc.">
                                @error('address')
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                @enderror
                            </div>
                            @error('address')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Número -->
                        <div>
                            <label for="address_number" class="block text-sm font-medium text-gray-700">
                                Número <span class="text-red-500">*</span>
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="text" id="address_number" name="address_number" value="{{ old('address_number') }}" required
                                    class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-3 pr-10 py-3 sm:text-sm border-gray-300 rounded-md @error('address_number') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror"
                                    placeholder="123">
                                @error('address_number')
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                @enderror
                            </div>
                            @error('address_number')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="is_active" class="block text-sm font-medium text-gray-700">
                            Status
                        </label>
                        <div class="mt-1">
                            <select id="is_active" name="is_active"
                                class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-3 pr-10 py-3 sm:text-sm border-gray-300 rounded-md @error('is_active') border-red-300 text-red-900 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror">
                                <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Ativo</option>
                                <option value="0" {{ old('is_active') === '0' ? 'selected' : '' }}>Inativo</option>
                            </select>
                        </div>
                        @error('is_active')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-sm text-gray-500">
                            Defina o status inicial da secretaria.
                        </p>
                    </div>

                    <!-- Descrição -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">
                            Descrição (opcional)
                        </label>
                        <div class="mt-1">
                            <textarea id="description" name="description" rows="3"
                                class="focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('description') border-red-300 @enderror"
                                placeholder="Adicione informações adicionais sobre a secretaria">{{ old('description') }}</textarea>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">
                            Informações complementares sobre a secretaria.
                        </p>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Ações -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <div class="text-sm">
                            <a href="{{ route('departments.index') }}" class="font-medium text-blue-600 hover:text-blue-500 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                                </svg>
                                Voltar para a lista
                            </a>
                        </div>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Cadastrar Secretaria
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Máscara para CEP
    const cepInput = document.getElementById('cep');
    
    if (cepInput) {
        cepInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 5) {
                value = value.substring(0, 5) + '-' + value.substring(5, 8);
            }
            e.target.value = value;
            
            // Buscar endereço automaticamente quando CEP estiver completo
            if (value.length === 9) {
                buscarEnderecoPorCEP(value);
            }
        });
    }

    // Função para buscar endereço via API ViaCEP
    function buscarEnderecoPorCEP(cep) {
        const cepNumerico = cep.replace(/\D/g, '');
        
        if (cepNumerico.length !== 8) return;
        
        // Mostrar loading
        const enderecoInput = document.getElementById('address');
        enderecoInput.disabled = true;
        enderecoInput.placeholder = 'Buscando endereço...';
        
        fetch(`https://viacep.com.br/ws/${cepNumerico}/json/`)
            .then(response => response.json())
            .then(data => {
                if (!data.erro) {
                    // Preencher endereço automaticamente
                    document.getElementById('address').value = data.logradouro || '';
                    
                    // Se quiser, pode preencher também outros campos
                    // document.getElementById('bairro').value = data.bairro || '';
                    // document.getElementById('city').value = data.localidade || '';
                    // document.getElementById('state').value = data.uf || '';
                }
            })
            .catch(error => {
                console.error('Erro ao buscar CEP:', error);
            })
            .finally(() => {
                enderecoInput.disabled = false;
                enderecoInput.placeholder = 'Rua, Avenida, etc.';
            });
    }

    // Auto-focus no primeiro campo
    document.getElementById('name')?.focus();
});
</script>
@endpush