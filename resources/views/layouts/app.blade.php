<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="{{asset('assets/images/logo_prefeitura_cabedelo.png')}}" >
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Manifest -->
        <link rel="manifest" href="/manifest.json" type="application/manifest+json">

        <!-- Ícone para iOS -->
        <link rel="apple-touch-icon" href="{{ asset('assets/icons/gestin_icone_192.png') }}">

        <!-- Cor da barra de status -->
        <meta name="theme-color" content="#004aad">

        <!-- iOS WebApp -->
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta name="apple-mobile-web-app-title" content="GestIn">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
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

        <script>
            (function() {
                const isLocal = ['localhost', '127.0.0.1'].includes(location.hostname) || location.hostname.endsWith('.test');
                const isProd = {{ App::environment('production') ? 'true' : 'false' }};
                const isHttps = location.protocol === 'https:';
                const enableSW = isHttps || isLocal || isProd;

                if ('serviceWorker' in navigator && enableSW) {
                    const swUrl = "/service-worker.js";
                    window.addEventListener('load', () => {
                        navigator.serviceWorker.register(swUrl)
                            .then((registration) => {
                                console.log('✅ Service Worker registrado:', registration);

                                // Fluxo de atualização: solicita ativação imediata do SW novo
                                function requestSkipWaiting(reg) {
                                    if (reg && reg.waiting) {
                                        reg.waiting.postMessage({ type: 'SKIP_WAITING' });
                                    }
                                }

                                // Detecta novo SW instalado
                                registration.addEventListener('updatefound', () => {
                                    const newWorker = registration.installing;
                                    if (!newWorker) return;
                                    newWorker.addEventListener('statechange', () => {
                                        if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                                            requestSkipWaiting(registration);
                                        }
                                    });
                                });

                                // Se já existe um waiting (atualização feita em segundo plano)
                                requestSkipWaiting(registration);

                                // Recarrega quando o novo SW assume o controle
                                let refreshing = false;
                                navigator.serviceWorker.addEventListener('controllerchange', () => {
                                    if (refreshing) return;
                                    refreshing = true;
                                    window.location.reload();
                                });
                            })
                            .catch(err => console.error('Erro ao registrar SW:', err));
                    });
                }
            })();
        </script>
        @stack('scripts')
    </body>
</html>
