@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Dashboard') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Grid de Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Card Categorias -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg h-full flex flex-col">
                    <div class="p-6 flex items-center flex-grow">
                        <div class="bg-green-100 dark:bg-green-900 p-3 rounded-full mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600 dark:text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                        </div>
                        <div class="flex-grow">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Categorias</h3>
                            <p class="text-gray-500 dark:text-gray-400">Gerencie suas categorias</p>
                        </div>
                    </div>
                    <div class="px-6 pb-4 flex justify-between">
                        <a href="{{ route('categories.index') }}" class="text-sm font-medium text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300 transition-colors">
                            Ver todas
                        </a>
                        <a href="{{ route('categories.create') }}" class="text-sm font-medium bg-green-500 hover:bg-green-600 text-white py-1 px-3 rounded-lg transition-colors flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Nova categoria
                        </a>
                    </div>
                </div>

                <!-- Card Produtos -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg h-full flex flex-col">
                    <div class="p-6 flex items-center flex-grow">
                        <div class="bg-green-100 dark:bg-green-900 p-3 rounded-full mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600 dark:text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                        </div>
                        <div class="flex-grow">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Produtos</h3>
                            <p class="text-gray-500 dark:text-gray-400">Gerencie seus Produtos</p>
                        </div>
                    </div>
                    <div class="px-6 pb-4 flex justify-between">
                        <a href="#" class="text-sm font-medium text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300 transition-colors">
                            Ver todas
                        </a>
                        <a href="{{ route('products.create') }}" class="text-sm font-medium bg-green-500 hover:bg-green-600 text-white py-1 px-3 rounded-lg transition-colors flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Nova categoria
                        </a>
                    </div>
                </div>

                <!-- Card Fornecedores -->
                <a href="#" class="transform transition hover:scale-105">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg h-full">
                        <div class="p-6 flex items-center">
                            <div class="bg-purple-100 dark:bg-purple-900 p-3 rounded-full mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-600 dark:text-purple-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Fornecedores</h3>
                                <p class="text-gray-500 dark:text-gray-400">Gerencie seus fornecedores</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection