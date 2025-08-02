@extends('layouts.app')

@section('title', 'Editar Produto')

@section('content')
<div class="container mx-auto px-4 py-8 mt-4">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gray-800 text-white px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-semibold">Editar Produto</h1>
            <a href="{{ route('products.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Voltar
            </a>
        </div>

        <div class="p-6">
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

            <form action="{{ route('products.update', $product->id) }}" method="POST">
                @method('PUT')
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Nome do Produto -->
                    <div>
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">
                            Nome do Produto <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <!-- Código do Produto -->
                    <div>
                        <label for="code" class="block text-gray-700 text-sm font-bold mb-2">
                            Código do Produto <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="code" id="code" value="{{ old('code', $product->code) }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <!-- Categoria -->
                    <div>
                        <label for="category_id" class="block text-gray-700 text-sm font-bold mb-2">
                            Categoria <span class="text-red-500">*</span>
                        </label>
                        <select name="category_id" id="category_id"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">Selecione uma categoria</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Unidade de Medida -->
                    <div>
                        <label for="meansurement_unit" class="block text-gray-700 text-sm font-bold mb-2">
                            Unidade de Medida
                        </label>
                        <select name="meansurement_unit_id" id="meansurement_unit_id"
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
                                <option value="unidade">
                                    unidade
                                </option>
                        </select>
                        <div class="mt-2">
                            <input type="checkbox" id="custom_unit_checkbox" class="mr-2" {{ old('custom_meansurement_unit', $product->meansurement_unit && !in_array($product->meansurement_unit, ['m', 'cm', 'mm', 'pc', 'unidade'])) ? 'checked' : '' }}>
                            <label for="custom_unit_checkbox" class="text-gray-700 text-sm">Usar unidade de medida personalizada</label>
                        </div>
                        <div id="custom_unit_input" class="mt-2 {{ old('custom_meansurement_unit', $product->meansurement_unit && !in_array($product->meansurement_unit, ['m', 'cm', 'mm', 'pc', 'unidade'])) ? '' : 'hidden' }}">
                            <label for="custom_unit" class="block text-gray-700 text-sm font-bold mb-2">Unidade de Medida Personalizada</label>
                            <input type="text" name="custom_meansurement_unit" id="custom_unit" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('custom_meansurement_unit', $product->meansurement_unit && !in_array($product->meansurement_unit, ['m', 'cm', 'mm', 'pc', 'unidade']) ? $product->meansurement_unit : '') }}">
                        </div>
                    </div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const customUnitCheckbox = document.getElementById('custom_unit_checkbox');
        const customUnitInputDiv = document.getElementById('custom_unit_input');
        const meansurementUnitSelect = document.getElementById('meansurement_unit_id');

        // Set initial state of select based on product's meansurement_unit
        const productMeansurementUnit = "{{ $product->meansurement_unit }}";
        const predefinedUnits = ['m', 'cm', 'mm', 'pc', 'unidade'];

        if (predefinedUnits.includes(productMeansurementUnit)) {
            meansurementUnitSelect.value = productMeansurementUnit;
            customUnitInputDiv.classList.add('hidden');
            customUnitCheckbox.checked = false;
        } else if (productMeansurementUnit) {
            customUnitCheckbox.checked = true;
            customUnitInputDiv.classList.remove('hidden');
            meansurementUnitSelect.disabled = true;
        } else {
            customUnitInputDiv.classList.add('hidden');
            customUnitCheckbox.checked = false;
            meansurementUnitSelect.disabled = false;
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

                    <!-- Observação -->
                    <div>
                        <label for="observation" class="block text-gray-700 text-sm font-bold mb-2">
                            Observação
                        </label>
                        <textarea name="observation" id="observation"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline h-24">{{ old('observation', $product->observation) }}</textarea>
                    </div>

                    <!-- Status -->
                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                            class="mr-2 leading-tight">
                        <label for="is_active" class="text-sm">
                            Ativo
                        </label>
                    </div>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Atualizar Produto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection