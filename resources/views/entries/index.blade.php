<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Entradas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('entries.create') }}" class="btn btn-primary bg-blue-500 text-white px-4 py-2 rounded-md">Adicionar Entrada</a>
                    </div>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fornecedor</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data de Entrada</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Número da Nota Fiscal</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Observação</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($entries as $entry)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $entry->supplier->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $entry->entry_date }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $entry->invoice_number }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $entry->observation }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('entries.show', $entry) }}" class="text-blue-600 hover:text-blue-900 mr-2">Ver</a>
                                        <a href="{{ route('entries.edit', $entry) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">Editar</a>
                                        <form action="{{ route('entries.destroy', $entry) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Excluir</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $entries->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 