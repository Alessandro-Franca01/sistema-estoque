@extends('layouts.app')

@section('title', 'Editar Fornecedor')

@section('content')
<div class="container mx-auto px-4 py-8 mt-4">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gray-800 text-white px-6 py-4">
            <h1 class="text-2xl font-semibold">Editar Fornecedor</h1>
        </div>
        <div class="p-6">
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <strong>Ops! Corrija o(s) erro(s) abaixo:</strong>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('suppliers.update', $supplier) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Coluna 1 -->
                    <div class="space-y-4">
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">
                                E-mail
                            </label>
                            <input type="email" name="email" id="email" value="{{ old('email', $supplier->email) }}"
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
                            <input type="text" name="phone" id="phone" value="{{ old('phone', $supplier->phone) }}"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('phone') border-red-500 @enderror">
                            @error('phone')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <!-- Coluna 2 -->
                    <div class="space-y-4">
                        <!-- Notas -->
                        <div>
                            <label for="observation" class="block text-gray-700 text-sm font-bold mb-2">
                                Observações
                            </label>
                            <textarea name="observation" id="observation" rows="3"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('observation') border-red-500 @enderror">{{ old('observation', $supplier->observation) }}</textarea>
                            @error('observation')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Status -->
                        <div class="space-y-2">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="active" value="1" @checked(old('active', $supplier->active))
                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-gray-700">Fornecedor ativo</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-between mt-6">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Salvar Alterações
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
