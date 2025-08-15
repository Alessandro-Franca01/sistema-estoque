@extends('layouts.app')

@section('title', 'Editar Categoria')

@section('content')
<div class="container mx-auto px-4 py-8 mt-4">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gray-800 text-white px-6 py-4">
            <h1 class="text-2xl font-semibold">Editar Categoria</h1>
        </div>

        <div class="p-6">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">
                        Nome da Categoria <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-gray-700 text-sm font-bold mb-2">
                        Descrição (opcional)
                    </label>
                    <textarea name="description" id="description" rows="3"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('description', $category->description) }}</textarea>
                </div>

                <div class="flex items-center justify-between mt-6 gap-2 flex-wrap">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Salvar Alterações
                    </button>

                    @if(auth()->user()->hasRole('administrador'))
                    <form action="{{ route('categories.toggle-status', $category->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja {{ $category->is_active ? 'desativar' : 'ativar' }} esta categoria?');">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="{{ $category->is_active ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-500 hover:bg-green-600' }} text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            {{ $category->is_active ? 'Desativar' : 'Ativar' }}
                        </button>
                    </form>
                    @endif

                    <a href="{{ route('categories.index') }}"
                        class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                        Voltar para a lista
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
