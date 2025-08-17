@extends('layouts.app')

@section('title', 'Detalhes da Entrada')

@section('content')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <strong>Fornecedor:</strong> {{ $entry->supplier->name }}
                    </div>
                    <div class="mb-4">
                        <strong>Tipo de Entrada:</strong>
                        @php($types = ['purchased' => 'Compra', 'feeding' => 'Alimentação', 'reversal' => 'Estorno'])
                        {{ $types[$entry->entry_type] ?? $entry->entry_type }}
                    </div>
                    <div class="mb-4">
                        <strong>Data de Entrada:</strong> {{ $entry->entry_date }}
                    </div>
                    <div class="mb-4">
                        <strong>Observação:</strong> {{ $entry->observation ?? 'N/A' }}
                    </div>
                    <div class="mb-4">
                        <strong>É Existente:</strong> {{ $entry->is_existing ? 'Sim' : 'Não' }}
                    </div>
                    <div class="mb-4">
                        <strong>Número da Nota Fiscal:</strong> {{ $entry->invoice_number ?? 'N/A' }}
                    </div>
                    <div class="mb-4">
                        <strong>Número do Contrato:</strong> {{ $entry->contract_number ?? 'N/A' }}
                    </div>
                    <div class="mb-4">
                        <strong>Número do Lote (Geral):</strong> {{ $entry->batch_number ?? 'N/A' }}
                    </div>
                    <div class="mb-4">
                        <strong>Valor Total:</strong> {{ number_format($entry->value, 2, ',', '.') }}
                    </div>

                    <h3 class="font-semibold text-lg text-gray-800 leading-tight mt-6 mb-4">Produtos da Entrada</h3>
                    @if ($entry->products->count() > 0)
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produto</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lote</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantidade</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Custo Unitário</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Custo Total</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($entry->products as $product)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $product->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $product->pivot->batch_item ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $product->pivot->quantity }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ number_format($product->pivot->unit_cost, 2, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ number_format($product->pivot->total_cost, 2, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>Nenhum produto associado a esta entrada.</p>
                    @endif

                    <div class="mt-6">
                        <a href="{{ route('entries.index') }}" class="btn btn-secondary bg-gray-200 px-4 py-2 rounded-md">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
