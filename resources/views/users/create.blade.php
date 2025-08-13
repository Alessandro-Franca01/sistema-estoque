@extends('layouts.app')

@section('title', 'Cadastrar Servidor Público')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gray-800 text-white px-6 py-4">
                <h1 class="text-2xl font-semibold">Cadastrar Usuário</h1>
            </div>

            <div class="p-6">
{{--                TODO: Testar cadastro de registro --}}
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Coluna 1 -->
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

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror"
                                       required>
                                @error('email')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- CPF -->
                            <div>
                                <label for="cpf" class="block text-gray-700 text-sm font-bold mb-2">
                                    CPF <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="cpf" id="cpf" value="{{ old('cpf') }}" maxlength="11"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('cpf') border-red-500 @enderror"
                                       required>
                                @error('cpf')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Departamento -->
                            <div>
                                <label for="department" class="block text-gray-700 text-sm font-bold mb-2">
                                    Departamento <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="department" id="department" value="{{ old('department') }}"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('department') border-red-500 @enderror"
                                       required>
                                @error('department')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Senha -->
                            <div>
                                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">
                                    Senha <span class="text-red-500">*</span>
                                </label>
                                <input type="password" name="password" id="password"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror"
                                       required>
                                @error('password')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Coluna 2 -->
                        <div class="space-y-6">
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

                            <!-- Cargo -->
                            <div>
                                <label for="position" class="block text-gray-700 text-sm font-bold mb-2">
                                    Cargo <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="position" id="position" value="{{ old('position') }}"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('position') border-red-500 @enderror"
                                       required>
                                @error('position')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Função -->
                            <div>
                                <label for="job_function" class="block text-gray-700 text-sm font-bold mb-2">
                                    Função <span class="text-red-500">*</span>
                                </label>
                                    <select name="job_function" id="job_function"
                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('role') border-red-500 @enderror" required>
                                        <option value="">Selecione um perfil</option>
                                        @foreach(['ADMINISTRADOR', 'ALMOXARIFE', 'SERVIDOR'] as $role)
                                            <option value="{{ $role }}" @selected(old('role') == $role)>{{ $role }}</option>
                                        @endforeach
                                    </select>
                                @error('job_function')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirmar Senha -->
                            <div>
                                <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">
                                    Confirmar Senha <span class="text-red-500">*</span>
                                </label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                       required>
                            </div>
                        </div>
                    </div>

                    <!-- Perfil (ocupa duas colunas) -->
                    <div class="mt-6">
                        <label for="role" class="block text-gray-700 text-sm font-bold mb-2">
                            Perfil de Acesso <span class="text-red-500">*</span>
                        </label>
                        <select name="role" id="role"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('role') border-red-500 @enderror" required>
                            <option value="">Selecione um perfil</option>
                            @foreach(['ADMINISTRADOR', 'ALMOXARIFE', 'SERVIDOR', 'AUDITOR'] as $role)
                                <option value="{{ $role }}" @selected(old('role') == $role)>{{ $role }}</option>
                            @endforeach
                        </select>
                        @error('role')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Ativo -->
                    <div class="flex items-center mt-6">
                        <input type="checkbox" name="active" id="active" value="1"
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" @checked(old('active', true))>
                        <label for="active" class="ml-2 block text-gray-700 text-sm font-bold">
                            Ativo
                        </label>
                    </div>

                    <div class="flex items-center justify-between mt-8">
                        <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
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
