<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
         <script src="https://cdn.tailwindcss.com"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased flex flex-col min-h-screen">
        <div class="flex-grow">
            <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
                @include('layouts.navigation')

                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white dark:bg-gray-800 shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="pb-16">
                    @yield('content')
                </main>
            </div>
        </div>

        <!-- Rodapé -->
        <footer class="bg-white dark:bg-gray-800 shadow-lg border-t border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-center items-center">
                    <div class="text-center md:mb-0">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            &copy; {{ now()->year }} SECTIN - Secretaria de Tecnologia, Ciência e Inovação.<br>
                                Desenvolvido por: <span class="font-medium text-gray-700 dark:text-gray-300">Alessandro de França Silva</span>
                        </p>
                    </div>
                    
                </div>
            </div>
        </footer>
        @stack('scripts')
    </body>
</html>