<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Call') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('calls.update', $call) }}">
                        @csrf
                        @method('PATCH')

                        <!-- Type -->
                        <div>
                            <x-input-label for="type" :value="__('Type')" />
                            <x-text-input id="type" class="block mt-1 w-full" type="text" name="type" :value="old('type', $call->type)" required autofocus />
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <!-- Service Order -->
                        <div class="mt-4">
                            <x-input-label for="service_order" :value="__('Service Order')" />
                            <x-text-input id="service_order" class="block mt-1 w-full" type="text" name="service_order" :value="old('service_order', $call->service_order)" />
                            <x-input-error :messages="$errors->get('service_order')" class="mt-2" />
                        </div>

                        <!-- Connect Code -->
                        <div class="mt-4">
                            <x-input-label for="connect_code" :value="__('Connect Code')" />
                            <x-text-input id="connect_code" class="block mt-1 w-full" type="text" name="connect_code" :value="old('connect_code', $call->connect_code)" />
                            <x-input-error :messages="$errors->get('connect_code')" class="mt-2" />
                        </div>

                        <!-- Phone -->
                        <div class="mt-4">
                            <x-input-label for="phone" :value="__('Phone')" />
                            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone', $call->phone)" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>

                        <!-- Applicant -->
                        <div class="mt-4">
                            <x-input-label for="applicant" :value="__('Applicant')" />
                            <x-text-input id="applicant" class="block mt-1 w-full" type="text" name="applicant" :value="old('applicant', $call->applicant)" />
                            <x-input-error :messages="$errors->get('applicant')" class="mt-2" />
                        </div>

                        <!-- Observation -->
                        <div class="mt-4">
                            <x-input-label for="observation" :value="__('Observation')" />
                            <textarea id="observation" name="observation" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('observation', $call->observation) }}</textarea>
                            <x-input-error :messages="$errors->get('observation')" class="mt-2" />
                        </div>

                        <!-- Output ID -->
                        <div class="mt-4">
                            <x-input-label for="output_id" :value="__('Output ID')" />
                            <x-text-input id="output_id" class="block mt-1 w-full" type="number" name="output_id" :value="old('output_id', $call->output_id)" required />
                            <x-input-error :messages="$errors->get('output_id')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Update') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
