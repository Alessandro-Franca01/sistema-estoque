@extends('layouts.app')

@section('content')
    <div class="min-h-[60vh] flex items-center justify-center">
        <div class="text-center max-w-2xl px-6">
            <div class="mx-auto mb-6 w-20 h-20 rounded-full bg-red-100 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 text-red-600">
                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.28 6.22a.75.75 0 011.06 0L12 8.19l.22-.22a.75.75 0 111.06 1.06L13.06 9.25l.22.22a.75.75 0 11-1.06 1.06L12 10.31l-.22.22a.75.75 0 11-1.06-1.06l.22-.22-.22-.22a.75.75 0 010-1.06zM9.75 14.25a.75.75 0 000 1.5h4.5a.75.75 0 000-1.5h-4.5z" clip-rule="evenodd" />
                </svg>
            </div>

            <h1 class="text-3xl font-bold text-gray-800 mb-2">Acesso negado</h1>
            <p class="text-gray-600 mb-6">Você não tem permissão para acessar esta página ou executar esta ação.</p>

            <div class="flex items-center gap-3 justify-center">
                @auth
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Voltar ao Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Ir para Login
                    </a>
                @endauth

                <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300">
                    Voltar à página anterior
                </a>
            </div>

            <p class="text-sm text-gray-500 mt-6">Código do erro: 403</p>
        </div>
    </div>
@endsection
