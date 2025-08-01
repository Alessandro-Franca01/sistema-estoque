@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Dashboard') }}
    </h2>
@endsection

@section('content')
    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Grid de Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                <!-- Card Categorias -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden flex flex-col border border-gray-200 dark:border-gray-700 transition-all hover:shadow-md">
                    <div class="p-4 sm:p-6 flex items-start flex-grow">
                        <div class="bg-green-100 dark:bg-green-900 p-2 sm:p-3 rounded-full mr-3 sm:mr-4 flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-8 sm:w-8 text-green-600 dark:text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                        </div>
                        <div class="flex-grow min-w-0">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white truncate">Categorias</h3>
                            <p class="text-sm sm:text-base text-gray-500 dark:text-gray-400 truncate">Gerencie suas categorias</p>
                        </div>
                    </div>
                    <div class="px-4 sm:px-6 pb-4 flex justify-between items-center">
                        <a href="{{ route('categories.index') }}" class="text-xs sm:text-sm font-medium text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300 transition-colors whitespace-nowrap">
                            Ver todas
                        </a>
                        <a href="{{ route('categories.create') }}" class="text-xs sm:text-sm font-medium bg-green-500 hover:bg-green-600 text-white py-1 px-2 sm:py-1 sm:px-3 rounded-lg transition-colors flex items-center whitespace-nowrap">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 sm:h-4 sm:w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Nova categoria
                        </a>
                    </div>
                </div>

                <!-- Card Produtos -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden flex flex-col border border-gray-200 dark:border-gray-700 transition-all hover:shadow-md">
                    <div class="p-4 sm:p-6 flex items-start flex-grow">
                        <div class="bg-blue-100 dark:bg-blue-900 p-2 sm:p-3 rounded-full mr-3 sm:mr-4 flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-8 sm:w-8 text-blue-600 dark:text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <div class="flex-grow min-w-0">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white truncate">Produtos</h3>
                            <p class="text-sm sm:text-base text-gray-500 dark:text-gray-400 truncate">Gerencie seus produtos</p>
                        </div>
                    </div>
                    <div class="px-4 sm:px-6 pb-4 flex justify-between items-center">
                        <a href="{{ route('products.index') }}" class="text-xs sm:text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors whitespace-nowrap">
                            Ver todos
                        </a>
                        <a href="{{ route('products.create') }}" class="text-xs sm:text-sm font-medium bg-blue-500 hover:bg-blue-600 text-white py-1 px-2 sm:py-1 sm:px-3 rounded-lg transition-colors flex items-center whitespace-nowrap">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 sm:h-4 sm:w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Novo produto
                        </a>
                    </div>
                </div>

                <!-- Card Inventários -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden flex flex-col border border-gray-200 dark:border-gray-700 transition-all hover:shadow-md">
                    <div class="p-4 sm:p-6 flex items-start flex-grow">
                        <div class="bg-teal-100 dark:bg-teal-900 p-2 sm:p-3 rounded-full mr-3 sm:mr-4 flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-8 sm:w-8 text-teal-600 dark:text-teal-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div class="flex-grow min-w-0">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white truncate">Inventários</h3>
                            <p class="text-sm sm:text-base text-gray-500 dark:text-gray-400 truncate">Controle de estoque e inventários</p>
                        </div>
                    </div>
                    <div class="px-4 sm:px-6 pb-4 flex justify-between items-center">
                        <a href="{{ route('inventories.index') }}" class="text-xs sm:text-sm font-medium text-teal-600 dark:text-teal-400 hover:text-teal-800 dark:hover:text-teal-300 transition-colors whitespace-nowrap">
                            Ver estoque
                        </a>
                        <a href="{{ route('inventories.create') }}" class="text-xs sm:text-sm font-medium bg-teal-500 hover:bg-teal-600 text-white py-1 px-2 sm:py-1 sm:px-3 rounded-lg transition-colors flex items-center whitespace-nowrap">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 sm:h-4 sm:w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Novo inventário
                        </a>
                    </div>
                </div>

                <!-- Card Fornecedores -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden flex flex-col border border-gray-200 dark:border-gray-700 transition-all hover:shadow-md">
                    <div class="p-4 sm:p-6 flex items-start flex-grow">
                        <div class="bg-purple-100 dark:bg-purple-900 p-2 sm:p-3 rounded-full mr-3 sm:mr-4 flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-8 sm:w-8 text-purple-600 dark:text-purple-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div class="flex-grow min-w-0">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white truncate">Fornecedores</h3>
                            <p class="text-sm sm:text-base text-gray-500 dark:text-gray-400 truncate">Gerencie seus fornecedores</p>
                        </div>
                    </div>
                    <div class="px-4 sm:px-6 pb-4 flex justify-between items-center">
                        <a href="{{ route('suppliers.index') }}" class="text-xs sm:text-sm font-medium text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300 transition-colors whitespace-nowrap">
                            Ver todos
                        </a>
                        <a href="{{ route('suppliers.create') }}" class="text-xs sm:text-sm font-medium bg-purple-500 hover:bg-purple-600 text-white py-1 px-2 sm:py-1 sm:px-3 rounded-lg transition-colors flex items-center whitespace-nowrap">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 sm:h-4 sm:w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Novo fornecedor
                        </a>
                    </div>
                </div>

                <!-- Card Entradas de Produtos -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden flex flex-col border border-gray-200 dark:border-gray-700 transition-all hover:shadow-md">
                    <div class="p-4 sm:p-6 flex items-start flex-grow">
                        <div class="bg-amber-100 dark:bg-amber-900 p-2 sm:p-3 rounded-full mr-3 sm:mr-4 flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-8 sm:w-8 text-amber-600 dark:text-amber-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                        <div class="flex-grow min-w-0">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white truncate">Entradas</h3>
                            <p class="text-sm sm:text-base text-gray-500 dark:text-gray-400 truncate">Registre novas entradas de produtos</p>
                        </div>
                    </div>
                    <div class="px-4 sm:px-6 pb-4 flex justify-between items-center">
                        <a href="{{ route('entries.index') }}" class="text-xs sm:text-sm font-medium text-amber-600 dark:text-amber-400 hover:text-amber-800 dark:hover:text-amber-300 transition-colors whitespace-nowrap">
                            Ver histórico
                        </a>
                        <a href="{{ route('entries.create') }}" class="text-xs sm:text-sm font-medium bg-amber-500 hover:bg-amber-600 text-white py-1 px-2 sm:py-1 sm:px-3 rounded-lg transition-colors flex items-center whitespace-nowrap">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 sm:h-4 sm:w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Nova entrada
                        </a>
                    </div>
                </div>

                <!-- Card Saídas de Produtos -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden flex flex-col border border-gray-200 dark:border-gray-700 transition-all hover:shadow-md">
                    <div class="p-4 sm:p-6 flex items-start flex-grow">
                        <div class="bg-emerald-100 dark:bg-emerald-900 p-2 sm:p-3 rounded-full mr-3 sm:mr-4 flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-8 sm:w-8 text-emerald-600 dark:text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4M12 4l-8 8 8 8" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                        <div class="flex-grow min-w-0">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white truncate">Saídas</h3>
                            <p class="text-sm sm:text-base text-gray-500 dark:text-gray-400 truncate">Registre saídas de produtos</p>
                        </div>
                    </div>
                    <div class="px-4 sm:px-6 pb-4 flex justify-between items-center">
                        <a href="{{ route('outputs.index') }}" class="text-xs sm:text-sm font-medium text-emerald-600 dark:text-emerald-400 hover:text-emerald-800 dark:hover:text-emerald-300 transition-colors whitespace-nowrap">
                            Ver histórico
                        </a>
                        <a href="{{ route('outputs.create') }}" class="text-xs sm:text-sm font-medium bg-emerald-500 hover:bg-emerald-600 text-white py-1 px-2 sm:py-1 sm:px-3 rounded-lg transition-colors flex items-center whitespace-nowrap">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 sm:h-4 sm:w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Nova saída
                        </a>
                    </div>
                </div>
                
                <!-- Card Servidores Públicos -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden flex flex-col border border-gray-200 dark:border-gray-700 transition-all hover:shadow-md">
                    <div class="p-4 sm:p-6 flex items-start flex-grow">
                        <div class="bg-indigo-100 dark:bg-indigo-900 p-2 sm:p-3 rounded-full mr-3 sm:mr-4 flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-8 sm:w-8 text-indigo-600 dark:text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="flex-grow min-w-0">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white truncate">Servidores Públicos</h3>
                            <p class="text-sm sm:text-base text-gray-500 dark:text-gray-400 truncate">Gerencie os servidores cadastrados</p>
                        </div>
                    </div>
                    <div class="px-4 sm:px-6 pb-4 flex justify-between items-center">
                        <a href="{{ route('public_servants.index') }}" class="text-xs sm:text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition-colors whitespace-nowrap">
                            Ver todos
                        </a>
                        <a href="{{ route('public_servants.create') }}" class="text-xs sm:text-sm font-medium bg-indigo-500 hover:bg-indigo-600 text-white py-1 px-2 sm:py-1 sm:px-3 rounded-lg transition-colors flex items-center whitespace-nowrap">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 sm:h-4 sm:w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Novo servidor
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection