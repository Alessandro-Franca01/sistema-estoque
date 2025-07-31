@extends('layouts.app')

@section('title', 'Cadastrar Novo Inventário')

@section('content')
<div class="container mx-auto px-4 py-8 mt-4">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gray-800 text-white px-6 py-4">
            <h1 class="text-2xl font-semibold">Cadastrar Novo Inventário</h1>
        </div>

        <div class="p-6">
            <form action="{{ route('inventories.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="start_date" class="block text-gray-700 text-sm font-bold mb-2">
                        Data de Início <span class="text-red-500">*</span>
                    </label>
                    <input type="datetime-local" name="start_date" id="start_date" value="{{ old('start_date') }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('start_date') border-red-500 @enderror">
                    @error('start_date')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Produtos</label>
                    @foreach($products as $product)
                        <div class="flex items-center mb-2">
                            <input type="checkbox" name="products[]" value="{{ $product->id }}" id="product_{{ $product->id }}" class="mr-2">
                            <label for="product_{{ $product->id }}">{{ $product->name }} (Estoque: {{ $product->quantity }})</label>
                        </div>
                    @endforeach
                </div>

                <div class="flex items-center justify-between mt-6">
                <button type="submit" style="background-color: #22c55e;"
                    class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Cadastrar Inventário
                </button>
                                        <a href="{{ route('inventories.index') }}"
                        class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                        Voltar para a lista
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection