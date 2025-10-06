<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="py-12">
        @csrf

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Senha')" />
            <div class="relative">
                <x-text-input id="password" class="block mt-1 w-full pr-10"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
                <button type="button"
                        class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none"
                        onclick="togglePasswordVisibility('password', this)"
                        aria-label="{{ __('Mostrar/ocultar senha') }}">
                    <svg class="h-5 w-5" data-eye style="display: inline;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.036 12.322a1.012 1.012 0 010-.644C3.423 7.51 7.36 5 12 5c4.64 0 8.577 2.51 9.964 6.678.07.2.07.444 0 .644C20.577 16.49 16.64 19 12 19c-4.64 0-8.577-2.51-9.964-6.678z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <svg class="h-5 w-5" data-eye-off style="display: none;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3l18 18M10.584 10.587A3 3 0 0012 15a3 3 0 002.828-1.995M9.88 9.88A3 3 0 0115 12M6.227 6.23C4.35 7.4 2.954 9.05 2.036 11.678a1.012 1.012 0 000 .644C3.423 16.49 7.36 19 12 19c1.79 0 3.46-.39 4.95-1.09M9.9 4.24C10.58 4.08 11.28 4 12 4c4.64 0 8.577 2.51 9.964 6.678.07.2.07.444 0 .644-.43 1.296-1.08 2.47-1.91 3.48" />
                    </svg>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Lembre-me') }}</span>
            </label>
        </div>
{{--        {{ dd( Route::has('password.request'), config('custom.show_link_reset_pass')) }}--}}
        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request') && config('custom.show_link_reset_pass'))
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                        {{ __('Esquece a senha?') }}
                    </a>
                @endif

            <x-primary-button class="ms-3">
                {{ __('Entrar') }}
            </x-primary-button>
        </div>
        <div class="mt-6 text-center">
            <span class="text-sm text-gray-600 dark:text-gray-400">
                @if(config('custom.show_link_user_create'))
                    <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        {{ __('Cadastrar Novo Usuário') }}
                    </a>
                @endif
            </span>
        </div>
    </form>
    <script>
      function togglePasswordVisibility(inputId, btn) {
        const input = document.getElementById(inputId);
        if (!input) return;
        const isShowing = input.type === 'text';
        input.type = isShowing ? 'password' : 'text';
        const eye = btn.querySelector('[data-eye]');
        const eyeOff = btn.querySelector('[data-eye-off]');
        if (eye && eyeOff) {
          eye.style.display = isShowing ? 'inline' : 'none';
          eyeOff.style.display = isShowing ? 'none' : 'inline';
        }
      }
    </script>
</x-guest-layout>
