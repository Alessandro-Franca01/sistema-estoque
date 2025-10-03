@extends('layouts.app')

@section('title', 'Editar Servidor Público')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gray-800 text-white px-6 py-4">
            <h1 class="text-2xl font-semibold">Editar Servidor Público</h1>
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
            <form action="{{ route('public_servants.update', $publicServant->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-6">
                    <!-- Nome -->
                    <div>
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">
                            Nome Completo <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $publicServant->name) }}"
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
                        <input type="text" name="registration" id="registration" value="{{ old('registration', $publicServant->registration) }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('registration') border-red-500 @enderror"
                            required>
                        @error('registration')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- CPF -->
                    <div>
                        <label for="cpf" class="block text-gray-700 text-sm font-bold mb-2">
                            CPF <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="cpf" id="cpf" value="{{ old('cpf', $publicServant->cpf) }}" maxlength="11"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('cpf') border-red-500 @enderror"
                            required>
                        @error('cpf')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">
                            Email
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email', $publicServant->email) }}"
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
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $publicServant->phone) }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('phone') border-red-500 @enderror">
                        @error('phone')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    @php
                        $deptLink = $publicServant->departments->first();
                        $pivotJob = old('job_function', optional($deptLink?->pivot)->job_function);
                        $pivotPos = old('position', optional($deptLink?->pivot)->position);
                        $pivotDeptId = old('department_id', optional($deptLink)->id);
                        $pivotActive = old('is_active', optional($deptLink?->pivot)->is_active);
                    @endphp

                    <!-- Função (pivot job_function) -->
                    <div>
                        <label for="job_function" class="block text-gray-700 text-sm font-bold mb-2">
                            Função <span class="text-red-500">*</span>
                        </label>
                        <select name="job_function" id="job_function"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('job_function') border-red-500 @enderror" required>
                            <option value="">Selecione uma função</option>
                            @foreach(['ADMINISTRADOR','ALMOXARIFE','OPERADOR','SERVIDOR'] as $job_function)
                                <option value="{{ $job_function }}" @selected($pivotJob == $job_function)>{{ $job_function }}</option>
                            @endforeach
                        </select>
                        @error('job_function')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Cargo (pivot position) -->
                    <div>
                        <label for="position" class="block text-gray-700 text-sm font-bold mb-2">Cargo</label>
                        <input type="text" name="position" id="position" value="{{ $pivotPos }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('position') border-red-500 @enderror">
                        @error('position')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Departamento (pivot department_id) -->
                    <div>
                        <label for="department_id" class="block text-gray-700 text-sm font-bold mb-2">Departamento <span class="text-red-500">*</span></label>
                        <select name="department_id" id="department_id"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('department_id') border-red-500 @enderror" required>
                            <option value="">Selecione um departamento</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" @selected((string)$pivotDeptId === (string)$department->id)>{{ $department->name }}</option>
                            @endforeach
                        </select>
                        @error('department_id')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status do vínculo (pivot is_active) -->
                    <div class="flex items-center">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" id="is_active" value="1" class="mr-2" @checked((bool)$pivotActive)>
                        <label for="is_active" class="text-gray-700 text-sm font-bold">Vínculo Ativo</label>
                        @error('is_active')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="flex items-center justify-between mt-8">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Salvar Alterações
                    </button>
                    <a href="{{ route('public_servants.index') }}"
                        class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                        Voltar para a lista
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Máscara para CPF
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
