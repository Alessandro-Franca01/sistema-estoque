@extends('layouts.app')

@section('title', 'Usuários')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-7xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gray-800 text-white px-6 py-4 flex items-center justify-between">
                <h1 class="text-2xl font-semibold">Usuários</h1>
                <div class="flex items-center space-x-2">
                    <a href="{{ route('users.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md">
                        Novo Usuário
                    </a>
                </div>
            </div>

            <div class="p-6">
                @if(session('success'))
                    <div class="mb-4 p-3 rounded bg-green-50 text-green-700 border border-green-200">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="mb-4 p-3 rounded bg-red-50 text-red-700 border border-red-200">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if($users->isEmpty())
                    <p class="text-gray-600">Nenhum usuário encontrado.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Perfil</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($users as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm text-gray-900 font-medium">{{ $user->name }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $user->email }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $user->roles->first()->name === 'administrativo' ? 'bg-purple-100 text-purple-800' :
                                          ($user->roles->first()->name === 'almoxarife' ? 'bg-blue-100 text-blue-800' :
                                          'bg-gray-100 text-gray-800') }}">
                                            {{ $user->roles->first()->name }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        @php
                                            $isActive = $user->active ?? $user->is_active ?? null;
                                        @endphp
                                        @if($isActive === null)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">N/D</span>
                                        @elseif($isActive)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Ativo</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inativo</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
