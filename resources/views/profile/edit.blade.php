@extends('layouts.app')

@section('title', 'Meu Perfil')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Cabeçalho -->
            <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 px-6 py-5 rounded-t-lg">
                <h1 class="text-2xl font-bold text-white">Meu Perfil</h1>
                <p class="mt-1 text-indigo-100">Gerencie suas informações pessoais e configurações de conta</p>
            </div>

            <!-- Card de Informações do Perfil -->
            <div class="bg-white shadow-md rounded-b-lg overflow-hidden">
                <div class="p-6 space-y-6">
                    <!-- Atualizar Informações do Perfil -->
                    <div class="border-b border-gray-200 pb-6">
                        <div class="max-w-xl">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    <!-- Atualizar dados do Servidor Público -->
                    <div class="border-b border-gray-200 pb-6">
                        <div class="max-w-xl">
                            @include('profile.partials.update-public-servant-form')
                        </div>
                    </div>

                    <!-- Atualizar Senha -->
                    <div class="border-b border-gray-200 pb-6">
                        <div class="max-w-xl">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                    <!-- Excluir Conta -->
{{--                    <div>--}}
{{--                        <div class="max-w-xl">--}}
{{--                            @include('profile.partials.delete-user-form')--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>
@endsection
