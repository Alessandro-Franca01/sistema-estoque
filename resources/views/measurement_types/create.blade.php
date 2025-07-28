@extends('layouts.app')

@section('title', 'Novo Tipo de Medida')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gray-800 text-white px-6 py-4">
            <h1 class="text-2xl font-semibold">Novo Tipo de Medida</h1>
        </div>
        <div class="p-6">
            <form action="{{ route('measurement-types.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nome <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="acronym" class="block text-gray-700 text-sm font-bold mb-2">Sigla <span class="text-red-500">*</span></label>
                    <input type="text" name="acronym" id="acronym" value="{{ old('acronym') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('acronym') border-red-500 @enderror">
                    @error('acronym')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Descrição</label>
                    <textarea name="description" id="description" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('description') }}</textarea>
                </div>
                <div class="mb-4">
                    <label for="used_measurement" class="block text-gray-700 text-sm font-bold mb-2">Medida Usada</label>
                    <input type="number" step="0.01" name="used_measurement" id="used_measurement" value="{{ old('used_measurement') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', true)) class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <span class="ml-2 text-gray-700">Ativo</span>
                    </label>
                </div>
                <div class="flex items-center justify-between mt-6">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Salvar</button>
                    <a href="{{ route('measurement-types.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">Voltar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 