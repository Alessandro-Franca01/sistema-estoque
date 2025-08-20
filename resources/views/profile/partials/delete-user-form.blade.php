<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Excluir Conta
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Uma vez que sua conta for excluída, todos os seus recursos e dados serão permanentemente apagados. Antes de excluir sua conta, faça o download de quaisquer dados ou informações que deseja manter.
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
    >
        Excluir Conta
    </button>

    <div x-data="{ show: false }" x-show="show" x-on:open-modal.window="show = true" x-on:close.window="show = false" class="fixed inset-0 z-50 hidden" :class="{ 'hidden': !show }">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-0">
            <div class="relative w-full max-w-md transform rounded-lg bg-white text-left shadow-xl transition-all">
                <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                    @csrf
                    @method('delete')

                    <h2 class="text-lg font-medium text-gray-900 mb-4">
                        Tem certeza que deseja excluir sua conta?
                    </h2>

                    <p class="text-sm text-gray-600 mb-4">
                        Uma vez que sua conta for excluída, todos os seus recursos e dados serão permanentemente apagados. Por favor, digite sua senha para confirmar que deseja excluir permanentemente sua conta.
                    </p>

                    <div class="mb-4">
                        <label for="password" class="sr-only">Senha</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Digite sua senha"
                        />
                        @error('password', 'userDeletion')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" x-on:click="$dispatch('close')" class="inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Cancelar
                        </button>

                        <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            Excluir Conta
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
