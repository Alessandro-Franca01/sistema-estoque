<section>
    <header class="mb-6">
        <h2 class="text-lg font-medium text-gray-900">Informações do Servidor Público</h2>
        <p class="mt-1 text-sm text-gray-600">Atualize os dados vinculados ao seu cadastro de servidor.</p>
    </header>

    @php($servant = $user->publicServant)

    @if(!$servant)
        <div class="rounded-md bg-yellow-50 p-4 border border-yellow-200">
            <p class="text-sm text-yellow-800">
                Nenhum registro de Servidor Público vinculado à sua conta.
            </p>
        </div>
    @else

        <form method="post" action="{{ route('public_servants.update', $servant->id) }}" class="space-y-6">
            @csrf
            @method('patch')
            <input type="hidden" name="from_profile" value="1">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="ps_name" class="block text-sm font-medium text-gray-700">Nome Pessoal</label>
                    <input id="ps_name" name="name" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('name', $servant->name) }}" required />
                    @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
{{--                {{ strlen(preg_replace('/\D/', '', old('registration', $servant->registration))) == 7 ? '##.###-##' : '##.###-#' }}--}}
                <div>
                    <label for="registration" class="block text-sm font-medium text-gray-700">Matrícula</label>
                    <input id="registration" name="registration" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ customMask(old('registration', $servant->registration), '##.###-##') }}" required />
                    @error('registration')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="cpf" class="block text-sm font-medium text-gray-700">CPF</label>
                    <input id="cpf" name="cpf" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ formatDocument(old('cpf', $servant->cpf)) }}" required />
                    @error('cpf')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="ps_email" class="block text-sm font-medium text-gray-700">Email Secundário</label>
                    <input id="ps_email" name="email" type="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('email', $servant->email) }}" />
                    @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Telefone</label>
                    <input id="phone" name="phone" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ formatPhone(old('phone', $servant->phone)) }}" />
                    @error('phone')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

{{--                <div>--}}
{{--                    <label for="department" class="block text-sm font-medium text-gray-700">Departamento</label>--}}
{{--                    <input id="department" name="department" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('department', $servant->department) }}" required />--}}
{{--                    @error('department')--}}
{{--                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>--}}
{{--                    @enderror--}}
{{--                </div>--}}

{{--                <div>--}}
{{--                    <label for="position" class="block text-sm font-medium text-gray-700">Cargo</label>--}}
{{--                    <input id="position" name="position" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('position', $servant->position) }}" required />--}}
{{--                    @error('position')--}}
{{--                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>--}}
{{--                    @enderror--}}
{{--                </div>--}}

{{--                <div>--}}
{{--                    <label for="job_function" class="block text-sm font-medium text-gray-700">Função</label>--}}
{{--                    <select id="job_function" name="job_function" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>--}}
{{--                        @php($current = old('job_function', $servant->job_function))--}}
{{--                        <option value="OPERADOR" {{ $current === 'OPERADOR' ? 'selected' : '' }}>OPERADOR</option>--}}
{{--                        <option value="ALMOXARIFE" {{ $current === 'ALMOXARIFE' ? 'selected' : '' }}>ALMOXARIFE</option>--}}
{{--                        <option value="SERVIDOR" {{ $current === 'SERVIDOR' ? 'selected' : '' }}>SERVIDOR</option>--}}
{{--                    </select>--}}
{{--                    @error('job_function')--}}
{{--                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>--}}
{{--                    @enderror--}}
{{--                </div>--}}

{{--                <div class="flex items-center gap-2">--}}
{{--                    <input id="active" name="active" type="checkbox" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ old('active', $servant->active) ? 'checked' : '' }} />--}}
{{--                    <label for="active" class="text-sm font-medium text-gray-700">Ativo</label>--}}
{{--                    @error('active')--}}
{{--                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>--}}
{{--                    @enderror--}}
{{--                </div>--}}
            </div>

            <div class="flex items-center gap-4">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Salvar
                </button>

                @if (session('status') === 'public-servant-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-600">Salvo.</p>
                @endif
            </div>
        </form>
    @endif
</section>
