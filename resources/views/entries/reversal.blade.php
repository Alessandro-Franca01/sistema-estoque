@extends('layouts.app')

@section('title', 'Estornar Entrada')

@section('content')
    <div class="container mx-auto px-4 py-8 mt-4">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gray-800 text-white px-6 py-4">
                <h1 class="text-2xl font-semibold">Estono de Entrada</h1>
            </div>
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="p-6">
                <form action="{{ route('entries.reversal') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <!-- Entrada -->
                        <div class="mb-4">
                            <label for="entry_type" class="block text-gray-700 text-sm font-bold mb-2">
                                Entradas <span class="text-red-500">*</span>
                            </label>
                            <select name="entry" id="entry" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('supplier_id') border-red-500 @enderror" required>
                                <option value="">Data da Entrada - Contrato</option>
                                @foreach ($entries as $entry)
                                    <option value="{{ $entry->id }}" @selected(old('entry') == $entry->id)>
                                        {{ $entry->entry_date->format('d/m/Y') }} - {{ $entry->contract_number }}
                                    </option>
                                @endforeach
                            </select>
                            @error('supplier_id')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Observação -->
                        <div class="mb-4">
                            <label for="observation" class="block text-gray-700 text-sm font-bold mb-2">
                                Motivação
                            </label>
                            <textarea name="observation" id="observation" rows="3"
                                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('observation') }}</textarea>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <button type="submit"
                                class="bg-orange-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Estornar Entrada
                        </button>

                        <a href="{{ route('entries.index') }}"
                           class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                            Voltar para a lista
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
