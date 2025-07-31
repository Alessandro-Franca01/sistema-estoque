@extends('layouts.app')

@section('title', 'Detalhes do Inventário')

@section('content')
<div class="container mx-auto px-4 py-8 mt-4">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gray-800 text-white px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-semibold">Detalhes do Inventário #{{ $inventory->id }}</h1>
            <a href="{{ route('inventories.edit', $inventory->id) }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mr-2">
                Adicionar Produtos
            </a>
            <a href="{{ route('inventories.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Voltar
            </a>
        </div>

        <div class="p-6">
            <div class="mb-4">
                <p><strong>Data de Início:</strong> {{ $inventory->start_date }}</p>
                <p><strong>Data de Fim:</strong> {{ $inventory->end_date ?? 'N/A' }}</p>
                <p><strong>Status:</strong> {{ $inventory->status }}</p>
                <p><strong>Responsável:</strong> {{ $inventory->user->name }}</p>
            </div>

            <h2 class="text-xl font-semibold mb-4">Itens do Inventário</h2>

            @if ($inventory->items->isEmpty())
                <p class="text-gray-600">Nenhum item neste inventário.</p>
            @else
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Produto</th>
                            <th class="px-4 py-2">Quantidade Registrada</th>
                            <th class="px-4 py-2">Quantidade Real</th>
                            <th class="px-4 py-2">Diferença</th>
                            <th class="px-4 py-2">Observações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inventory->items as $item)
                            <tr>
                                <td class="px-4 py-2">{{ $item->product->name }}</td>
                                <td class="px-4 py-2">{{ $item->register_amount }}</td>
                                <td class="px-4 py-2">{{ $item->real_amount ?? 'N/A' }}</td>
                                <td class="px-4 py-2">{{ $item->difference ?? 'N/A' }}</td>
                                <td class="px-4 py-2">{{ $item->observations ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection