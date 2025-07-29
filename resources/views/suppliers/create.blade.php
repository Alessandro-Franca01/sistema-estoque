@extends('layouts.app')

@section('title', 'Cadastrar Novo Fornecedor')

@section('content')
<div class="container mx-auto px-4 py-8 mt-4">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gray-800 text-white px-6 py-4">
            <h1 class="text-2xl font-semibold">Cadastrar Novo Fornecedor</h1>
        </div>

        <div class="p-6">
            <form action="{{ route('suppliers.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Coluna 1 -->
                    <div class="space-y-4">
                        <!-- Razão Social -->
                        <div>
                            <label for="legal_name" class="block text-gray-700 text-sm font-bold mb-2">
                                Razão Social <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="legal_name" id="legal_name" value="{{ old('legal_name') }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('legal_name') border-red-500 @enderror">
                            @error('legal_name')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Nome Fantasia -->
                        <div>
                            <label for="trade_name" class="block text-gray-700 text-sm font-bold mb-2">
                                Nome Fantasia
                            </label>
                            <input type="text" name="trade_name" id="trade_name" value="{{ old('trade_name') }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('trade_name') border-red-500 @enderror">
                            @error('trade_name')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- CNPJ -->
                        <div>
                            <label for="cnpj" class="block text-gray-700 text-sm font-bold mb-2">
                                CNPJ <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="cnpj" id="cnpj" value="{{ old('cnpj') }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('cnpj') border-red-500 @enderror">
                            @error('cnpj')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Inscrição Estadual -->
                        <div>
                            <label for="state_registration" class="block text-gray-700 text-sm font-bold mb-2">
                                Inscrição Estadual
                            </label>
                            <input type="text" name="state_registration" id="state_registration" value="{{ old('state_registration') }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('state_registration') border-red-500 @enderror">
                            @error('state_registration')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Inscrição Municipal -->
                        <div>
                            <label for="municipal_registration" class="block text-gray-700 text-sm font-bold mb-2">
                                Inscrição Municipal
                            </label>
                            <input type="text" name="municipal_registration" id="municipal_registration" value="{{ old('municipal_registration') }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('municipal_registration') border-red-500 @enderror">
                            @error('municipal_registration')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <!-- Coluna 2 -->
                    <div class="space-y-4">
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">
                                E-mail
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
                        <!-- Notas -->
                        <div>
                            <label for="observation" class="block text-gray-700 text-sm font-bold mb-2">
                                Observações
                            </label>
                            <textarea name="observation" id="observation" rows="3"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('observation') border-red-500 @enderror">{{ old('notes') }}</textarea>
                            @error('observation')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Status -->
                        <div class="space-y-2">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="active" value="1" @checked(old('active', true))
                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-gray-700">Fornecedor ativo</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-between mt-6">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Cadastrar Fornecedor
                    </button>
                    <a href="{{ route('suppliers.index') }}"
                        class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                        Voltar para a lista
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
