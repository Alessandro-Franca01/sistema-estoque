@extends('layouts.app')

@section('title', 'Cadastrar Servidor Público')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gray-800 text-white px-6 py-4">
            <h1 class="text-2xl font-semibold">Cadastrar Servidor Público</h1>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Oops!</strong>
                <span class="block sm:inline">Houve alguns problemas com sua submissão.</span>
                <ul class="mt-3 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="p-6">
            <form action="{{ route('public_servants.store') }}" method="POST">
                @csrf
                <div class="space-y-6">
                    <!-- Nome -->
                    <div>
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">
                            Nome Completo <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror"
                            required autofocus>
                        @error('name')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Matrícula -->
                    <div>
                        <label for="registration" class="block text-gray-700 text-sm font-bold mb-2">
                            Matrícula <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="registration" id="registration" value="{{ old('registration') }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('registration') border-red-500 @enderror"
                            required>
                        @error('registration')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- CPF -->
                    <div>
                        <label for="cpf" class="block text-gray-700 text-sm font-bold mb-2">
                            CPF
                        </label>
                        <input type="text" name="cpf" id="cpf" value="{{ old('cpf') }}" maxlength="11"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('cpf') border-red-500 @enderror>
                        @error('cpf')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">
                            Email
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Telefone -->
                    <div>
                        <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">
                            Telefone
                        </label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('phone') border-red-500 @enderror">
                        @error('phone')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Função (job_function) -->
                    <div>
                        <label for="job_function" class="block text-gray-700 text-sm font-bold mb-2">
                            Função <span class="text-red-500">*</span>
                        </label>
                        <select name="job_function" id="job_function"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('role') border-red-500 @enderror" required>
                            <option value="">Selecione uma função</option>
                            @foreach(['OPERADOR','SERVIDOR'] as $job_function)
                                <option value="{{ $job_function }}" @selected(old('job_function') == $job_function)>{{ $job_function }}</option>
                            @endforeach
                        </select>
                        @error('job_function')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Cargo (position) -->
                    <div>
                        <label for="position" class="block text-gray-700 text-sm font-bold mb-2">Cargo</label>
                        <input type="text" name="position" id="position" value="{{ old('position') }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('position') border-red-500 @enderror">
                        @error('position')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Departamento (tenant) -->
                    <div>
                        <label for="department_id" class="block text-gray-700 text-sm font-bold mb-2">Departamento <span class="text-red-500">*</span></label>
                        <select name="department_id" id="department_id"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('department_id') border-red-500 @enderror" required>
                            <option value="">Selecione um departamento</option>
                            @isset($departments)
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" @selected(old('department_id') == $department->id)>{{ $department->name }}</option>
                                @endforeach
                            @endisset
                        </select>
                        @error('department_id')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tipo de Servidor -->
                    <div>
                        <label for="servant_type" class="block text-gray-700 text-sm font-bold mb-2">Tipo de Servidor <span class="text-red-500">*</span></label>
                        <select name="servant_type" id="servant_type"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('servant_type') border-red-500 @enderror" required>
                            <option value="">Selecione o tipo de servidor</option>
                            <option value="EFETIVO" @selected(old('servant_type') == 'EFETIVO')>Efetivo</option>
                            <option value="COMISSIONADO" @selected(old('servant_type') == 'COMISSIONADO')>Comissionado</option>
                            <option value="TERCEIRIZADO" @selected(old('servant_type') == 'TERCEIRIZADO')>Terceirizado</option>
                        </select>
                        @error('servant_type')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Empresa Terceirizada (mostrar apenas para terceirizados) -->
                    <div id="outsourced-company-container" class="hidden">
                        <label for="outsourced_company" class="block text-gray-700 text-sm font-bold mb-2">Empresa Terceirizada</label>
                        <input type="text" name="outsourced_company" id="outsourced_company" value="{{ old('outsourced_company') }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('outsourced_company') border-red-500 @enderror">
                        @error('outsourced_company')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="flex items-center justify-between mt-8">
                    <button type="submit"
                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Cadastrar Servidor
                    </button>
                    <a href="{{ route('public_servants.index') }}"
                        class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                        Voltar para a lista
                    </a>
                </div>
            </form>
        </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mostrar/ocultar campo de empresa terceirizada
        const servantTypeSelect = document.getElementById('servant_type');
        const outsourcedCompanyContainer = document.getElementById('outsourced-company-container');
        
        function toggleOutsourcedCompany() {
            if (servantTypeSelect && outsourcedCompanyContainer) {
                if (servantTypeSelect.value === 'TERCEIRIZADO') {
                    outsourcedCompanyContainer.classList.remove('hidden');
                    document.getElementById('outsourced_company').setAttribute('required', 'required');
                } else {
                    outsourcedCompanyContainer.classList.add('hidden');
                    document.getElementById('outsourced_company').removeAttribute('required');
                }
            }
        }
        
        // Verificar valor inicial
        if (servantTypeSelect) {
            toggleOutsourcedCompany();
            servantTypeSelect.addEventListener('change', toggleOutsourcedCompany);
        }

        // Código existente
        const cpfInput = document.getElementById('cpf');
        if (cpfInput) {
            cpfInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                e.target.value = value;
            });
        }

        // Máscara para telefone
        const phoneInput = document.getElementById('phone');
        if (phoneInput) {
            phoneInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                e.target.value = value;
            });
        }
    });
</script>
@endpush
@endsection
