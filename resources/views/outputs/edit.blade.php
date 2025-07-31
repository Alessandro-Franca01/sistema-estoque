<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Saída') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('outputs.update', $output) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="output_date" class="block font-medium text-sm text-gray-700">Data da Saída</label>
                                <input type="datetime-local" name="output_date" id="output_date" class="block mt-1 w-full" value="{{ $output->output_date->format('Y-m-d\TH:i') }}" required>
                            </div>
                            <div>
                                <label for="call_type" class="block font-medium text-sm text-gray-700">Tipo de Chamado</label>
                                <select name="call_type" id="call_type" class="block mt-1 w-full">
                                    <option value="whatsapp" {{ $output->call_type == 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                                    <option value="conectar_cabedelo" {{ $output->call_type == 'conectar_cabedelo' ? 'selected' : '' }}>Conectar Cabedelo</option>
                                    <option value="personally" {{ $output->call_type == 'personally' ? 'selected' : '' }}>Pessoalmente</option>
                                    <option value="phone" {{ $output->call_type == 'phone' ? 'selected' : '' }}>Telefone</option>
                                    <option value="other" {{ $output->call_type == 'other' ? 'selected' : '' }}>Outro</option>
                                </select>
                            </div>
                            <div>
                                <label for="caller_name" class="block font-medium text-sm text-gray-700">Nome do Solicitante</label>
                                <input type="text" name="caller_name" id="caller_name" class="block mt-1 w-full" value="{{ $output->caller_name }}">
                            </div>
                            <div>
                                <label for="destination" class="block font-medium text-sm text-gray-700">Destino</label>
                                <input type="text" name="destination" id="destination" class="block mt-1 w-full" value="{{ $output->destination }}">
                            </div>
                            <div>
                                <label for="public_servant_id" class="block font-medium text-sm text-gray-700">Funcionário</label>
                                <select name="public_servant_id" id="public_servant_id" class="block mt-1 w-full" required>
                                    @foreach ($public_servants as $servant)
                                        <option value="{{ $servant->id }}" {{ $output->public_servant_id == $servant->id ? 'selected' : '' }}>{{ $servant->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900">Produtos</h3>
                            <div id="products-container">
                                @foreach ($output->products as $index => $product)
                                    <div class="grid grid-cols-2 gap-6 product-entry mt-4">
                                        <div>
                                            <label class="block font-medium text-sm text-gray-700">Produto</label>
                                            <select name="products[{{ $index }}][product_id]" class="block mt-1 w-full">
                                                @foreach ($products as $prod)
                                                    <option value="{{ $prod->id }}" {{ $product->id == $prod->id ? 'selected' : '' }}>{{ $prod->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block font-medium text-sm text-gray-700">Quantidade</label>
                                            <input type="number" name="products[{{ $index }}][quantity]" class="block mt-1 w-full" value="{{ $product->pivot->quantity }}" min="1" required>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" id="add-product" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Adicionar Produto</button>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Atualizar Saída
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('add-product').addEventListener('click', function () {
            const container = document.getElementById('products-container');
            const index = container.children.length;
            const newEntry = document.createElement('div');
            newEntry.classList.add('grid', 'grid-cols-2', 'gap-6', 'product-entry', 'mt-4');
            newEntry.innerHTML = `
                <div>
                    <label class="block font-medium text-sm text-gray-700">Produto</label>
                    <select name="products[${index}][product_id]" class="block mt-1 w-full">
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block font-medium text-sm text-gray-700">Quantidade</label>
                    <input type="number" name="products[${index}][quantity]" class="block mt-1 w-full" min="1" required>
                </div>
            `;
            container.appendChild(newEntry);
        });
    </script>
</x-app-layout>