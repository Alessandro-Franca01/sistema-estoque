@extends('layouts.app')

@section('title', 'Enviar E-mail de Cadastro')

@section('content')
    <div class="max-w-2xl mx-auto px-4 py-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <div class="bg-gray-800 text-white px-6 py-4">
                <h1 class="text-xl font-semibold">Enviar E-mail de Cadastro</h1>
            </div>

            <div class="p-6">
                @if (session('success'))
                    <div class="mb-4 rounded-md bg-green-50 p-4 border border-green-200">
                        <div class="flex">
                            <div class="ml-3">
                                <p class="text-sm text-green-800">
                                    {{ session('success') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 rounded-md bg-red-50 p-4 border border-red-200">
                        <div class="flex">
                            <div class="ml-3">
                                <p class="text-sm text-red-800">
                                    Corrija os campos abaixo e tente novamente.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('users.send.email') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">
                            E-mail do Usuário
                            <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            class="block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="usuario@dominio.com"
                        />
                        @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="job_function" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">
                                Perfil do Usuário <span class="text-red-500">*</span>
                            </label>
                            <select name="role" id="role"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 leading-tight focus:outline-none focus:shadow-outline @error('role') border-red-500 @enderror" required>
                                <option value="">Selecione um perfil</option>
                                @foreach(['ADMINISTRATIVO', 'ALMOXARIFE'] as $role)
                                    <option value="{{ $role }}" @selected(old('role') == $role)>{{ $role }}</option>
                                @endforeach
                            </select>
                            @error('role')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="department_id" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">
                                Departamento <span class="text-red-500">*</span>
                            </label>
                            <select name="department_id" id="department_id"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 leading-tight focus:outline-none focus:shadow-outline @error('department_id') border-red-500 @enderror" required>
                                <option value="">Selecione um departamento</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" @selected(old('department_id') == $department->id)>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('department_id')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <a href="{{ route('dashboard') }}"
                           class="inline-flex items-center rounded-md border border-gray-300 dark:border-gray-700 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800">
                            Voltar
                        </a>

                        <button type="submit"
                                class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Enviar E-mail
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-xs text-gray-500 dark:text-gray-400">
                    Observação: Será enviado um e-mail para o usuário com um link para que ele possa fazer seu cadastro.
                </div>
            </div>
        </div>
    </div>
@endsection
