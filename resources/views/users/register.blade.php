<x-guest-layout>
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Oops!</strong>
            <span class="block sm:inline">Houve alguns problemas com sua submissão.</span>
            <ul class="mt-3 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h2 class="text-lg font-medium text-center text-gray-900 dark:text-gray-100">
        Cadastro de Usuário
    </h2>

    <form method="POST" action="{{ route('users.store') }}" class="space-y-6">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- COLUNA 1 - Informações Pessoais teste12345 -->
            <div class="px-2 mb-4">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 border-b pb-2 mb-4">
                    Pessoal
                </h2>

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Nome Completo')" class="mb-1" />
                    <x-text-input id="name" class="block w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- CPF -->
                <div>
                    <x-input-label for="cpf" :value="__('CPF')" class="mb-1" />
                    <x-text-input id="cpf" class="block w-full" type="text" name="cpf" :value="old('cpf')" required autocomplete="cpf" />
                    <x-input-error :messages="$errors->get('cpf')" class="mt-2" />
                </div>

                <!-- Phone -->
                <div>
                    <x-input-label for="phone" :value="__('Telefone')" class="mb-1" />
                    <x-text-input id="phone" class="block w-full" type="text" name="phone" :value="old('phone')" autocomplete="phone" />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>
            </div>

            <!-- COLUNA 2 - Informações Profissionais -->
            <div class="px-2 mb-4">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 border-b pb-2 mb-4">
                    Profissional
                </h2>

                <!-- Department (hidden) -->
                <input type="hidden" name="department_id" value="{{ request('department_id') }}">

                <!-- Registration -->
                <div>
                    <x-input-label for="registration" :value="__('Matrícula')" class="mb-1" />
                    <x-text-input id="registration" class="block w-full" type="text" name="registration" :value="old('registration')" required autocomplete="registration" />
                    <x-input-error :messages="$errors->get('registration')" class="mt-2" />
                </div>

                <!-- Position -->
                <div>
                    <x-input-label for="position" :value="__('Cargo')" class="mb-1" />
                    <x-text-input id="position" class="block w-full" type="text" name="position" :value="old('position')" autocomplete="position" />
                    <x-input-error :messages="$errors->get('position')" class="mt-2" />
                </div>
            </div>
        </div>

        <!-- Seção de Segurança (full width) -->
        <div class="mt-2 px-2">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 border-b pb-2 mb-4">
                Sistema
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <input type="hidden" name="role" value="{{ $perfil }}">
                <input type="hidden" name="email" value="{{ $email }}">
                <input type="hidden" name="job_function" value="{{ $jobFunction }}">
                <input type="hidden" name="isFromEmail" value=true>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Senha')" class="mb-1" />
                    <x-text-input id="password" class="block w-full" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirmar Senha')" class="mb-1" />
                    <x-text-input id="password_confirmation" class="block w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between mt-2 px-2">
            <a class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 underline focus:outline-none focus:ring-2 focus:ring-blue-500 rounded px-2 py-1"
               href="{{ route('login') }}">
                {{ __('Já possui cadastro?') }}
            </a>

            <x-primary-button class="w-full sm:w-auto justify-center mb-4">
                {{ __('Registrar') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
