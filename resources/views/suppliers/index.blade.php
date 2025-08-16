@extends('layouts.app')

@section('title', 'Fornecedores')

@section('content')
    @php
        // Pegandos as permissões do usuário
        $canAdmin = auth()->user()->hasRole('administrativo');
    @endphp
<div class="container mx-auto px-4 py-8 mt-4">
    <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gray-800 text-white px-6 py-4 flex items-center justify-between">
            <h1 class="text-2xl font-semibold">Fornecedores</h1>
            @if($canAdmin)
                <a href="{{ route('suppliers.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Novo
                </a>
            @endif
        </div>
        <div class="flex flex-col items-center overflow-x-auto">
            @if(session('success'))
                <div class="mb-4 text-green-600 font-semibold">
                    {{ session('success') }}
                </div>
            @endif
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-2">#</th>
                        <th class="px-4 py-2">Razão Social</th>
                        <th class="px-4 py-2">Nome Fantasia</th>
                        <th class="px-4 py-2">CNPJ</th>
                        <th class="px-4 py-2">Telefone</th>
                        <th class="px-4 py-2">E-mail</th>
                        <th class="px-4 py-2">Ativo</th>
                        <th class="px-4 py-2">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suppliers as $supplier)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $supplier->id }}</td>
                            <td class="px-4 py-2">{{ $supplier->legal_name }}</td>
                            <td class="px-4 py-2">{{ $supplier->trade_name }}</td>
                            <td class="px-4 py-2">{{ $supplier->cnpj }}</td>
                            <td class="px-4 py-2">{{ $supplier->phone }}</td>
                            <td class="px-4 py-2">{{ $supplier->email }}</td>
                            <td class="px-4 py-2">
                                @if($supplier->active)
                                    <span class="text-green-600 font-bold">Sim</span>
                                @else
                                    <span class="text-red-600 font-bold">Não</span>
                                @endif
                            </td>
                            @if ($canAdmin)
                            <td class="px-4 py-2 flex space-x-2">
                                <a href="{{ route('suppliers.edit', $supplier) }}" class="bg-yellow-400 hover:bg-yellow-500 text-danger font-bold py-1 px-3 rounded">Editar</a>
                            </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">Nenhum fornecedor cadastrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">
                {{ $suppliers->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
