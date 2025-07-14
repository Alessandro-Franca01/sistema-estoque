@extends('layouts.app')

@section('title', 'Cadastrar Novo Produto')

@section('content')
<div class="container mx-auto px-4 py-8 mt-4">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gray-800 text-white px-6 py-4">
            <h1 class="text-2xl font-semibold">Cadastrar Novo Produto</h1>
        </div>

        <div class="p-6">
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Coluna 1 -->
                    <div class="space-y-4">
                        <!-- Nome do Produto -->
                        <div>
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">
                                Nome do Produto <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror">
                            @error('name')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Código do Produto -->
                        <div>
                            <label for="code" class="block text-gray-700 text-sm font-bold mb-2">
                                Código do Produto <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="code" id="code" value="{{ old('code') }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('code') border-red-500 @enderror">
                            @error('code')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Descrição -->
                        <div>
                            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">
                                Descrição
                            </label>
                            <textarea name="description" id="description" rows="3"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('description') }}</textarea>
                        </div>

                        <!-- Categoria -->
                        <div>
                            <label for="category_id" class="block text-gray-700 text-sm font-bold mb-2">
                                Categoria <span class="text-red-500">*</span>
                            </label>
                            <select name="category_id" id="category_id"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('category_id') border-red-500 @enderror">
                                <option value="">Selecione uma categoria</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Preço -->
                        <div>
                            <label for="price" class="block text-gray-700 text-sm font-bold mb-2">
                                Preço <span class="text-red-500">*</span>
                            </label>
                            <input type="number" step="0.01" min="0" name="price" id="price" value="{{ old('price') }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('price') border-red-500 @enderror">
                            @error('price')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Estoque -->
                        <div class="space-y-2">
                            <label for="stock_quantity" class="block text-gray-700 text-sm font-bold mb-2">
                                Quantidade em Estoque <span class="text-red-500">*</span>
                            </label>
                            <input type="number" min="0" name="stock_quantity" id="stock_quantity" value="{{ old('stock_quantity', 0) }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('stock_quantity') border-red-500 @enderror">
                            @error('stock_quantity')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                            
                            <label class="inline-flex items-center mt-2">
                                <input type="checkbox" name="manage_stock" value="1" @checked(old('manage_stock', true))
                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-gray-700">Gerenciar estoque</span>
                            </label>
                        </div>

                        <!-- Status -->
                        <div class="space-y-2">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', true))
                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-gray-700">Produto ativo</span>
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center justify-between mt-6">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Cadastrar Produto
                    </button>
                    <a href="{{ route('products.index') }}"
                        class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                        Voltar para a lista
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection