<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="{{asset('assets/images/logo_prefeitura_cabedelo.png')}}" >
        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            <div class="flex flex-col md:flex-row justify-center items-center mt-4">
                <a href="/">
                    <img class="w-40 h-40 justify-items-center" src="{{ asset('assets/images/logo_prefeitura_cabedelo.png') }}" alt="Logo Cabedelo">
                </a>
                <h2 class="text-center text-xl font-bold text-gray-800 dark:text-gray-100 mt-4">
                    GESTIN - Inovação em Gestão de Estoque
                </h2>
            </div>

            <div class="w-full mt-6 px-6 shadow-md overflow-hidden sm:rounded-lg lg:mx-auto">
                {{ $slot }}
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
    </body>
</html>
