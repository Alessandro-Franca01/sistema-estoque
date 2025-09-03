@extends('layouts.app')

@section('title', 'Cadastrar Novo Produto')

@section('content')
<div class="container mx-auto px-4 py-8 mt-4">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gray-800 text-white px-6 py-4">
            <h1 class="text-2xl font-semibold">Cadastrar Novo Produto</h1>
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
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
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

                    <!-- Unidade de Medida -->
                    <div>
                        <label for="meansurement_unit" class="block text-gray-700 text-sm font-bold mb-2">
                            Unidade de Medida <span class="text-red-500">*</span>
                        </label>
                        <select name="meansurement_unit" id="meansurement_unit"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">Selecione uma unidade de medida</option>
                                <option value="m">
                                    metros
                                </option>
                                <option value="cm">
                                    centimetros
                                </option>
                                <option value="mm">
                                    milímetros
                                </option>
                                <option value="pc">
                                    peça
                                </option>
                                <option value="kg">
                                    kilos
                                </option>
                                <option value="unidade">
                                unidade
                            </option>
                        </select>
                        <div class="mt-2">
                            <input type="checkbox" id="custom_unit_checkbox" class="mr-2" {{ old('custom_meansurement_unit') ? 'checked' : '' }}>
                            <label for="custom_unit_checkbox" class="text-gray-700 text-sm">Usar unidade de medida personalizada</label>
                        </div>
                        <div id="custom_unit_input" class="mt-2 {{ old('custom_meansurement_unit') ? '' : 'hidden' }}">
                            <label for="custom_unit" class="block text-gray-700 text-sm font-bold mb-2">Unidade de Medida Personalizada</label>
                            <input type="text" name="custom_meansurement_unit" id="custom_unit" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('custom_meansurement_unit') }}">
                        </div>
                    </div>
                    <!-- Observação -->
                    <div>
                        <label for="note" class="block text-gray-700 text-sm font-bold mb-2">
                            Observação
                        </label>
                        <textarea name="note" id="note" rows="3"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('note') }}</textarea>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-6">
                    <button type="submit"
                        class="bg-green-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
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
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const customUnitCheckbox = document.getElementById('custom_unit_checkbox');
        const customUnitInputDiv = document.getElementById('custom_unit_input');
        const meansurementUnitSelect = document.getElementById('meansurement_unit_id');

        // Initial state based on old input
        if (customUnitCheckbox.checked) {
            meansurementUnitSelect.disabled = true;
        }

        customUnitCheckbox.addEventListener('change', function () {
            if (this.checked) {
                customUnitInputDiv.classList.remove('hidden');
                meansurementUnitSelect.value = ''; // Clear selection when custom is used
                meansurementUnitSelect.disabled = true; // Disable select when custom is used
            } else {
                customUnitInputDiv.classList.add('hidden');
                meansurementUnitSelect.disabled = false; // Enable select when custom is not used
            }
        });
    });
</script>
@endpush

@endsection
