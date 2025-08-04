@extends('layouts.app')

@section('title', 'Chamado')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <strong>Type:</strong> {{ $call->type }}
                    </div>
                    <div class="mb-4">
                        <strong>Service Order:</strong> {{ $call->service_order }}
                    </div>
                    <div class="mb-4">
                        <strong>Connect Code:</strong> {{ $call->connect_code }}
                    </div>
                    <div class="mb-4">
                        <strong>Phone:</strong> {{ $call->phone }}
                    </div>
                    <div class="mb-4">
                        <strong>Caller Name:</strong> {{ $call->caller_name }}
                    </div>
                    <div class="mb-4">
                        <strong>Observation:</strong> {{ $call->observation }}
                    </div>
                    <div class="mb-4">
                        <strong>Output ID:</strong> {{ $call->output_id }} {{-- TODO: ADD A DATA DA SAIDA AQUI --}}
                    </div>
                    <div class="flex justify-end">
                        <a href="{{ route('calls.index') }}" class="btn btn-secondary">Voltar para a Lista</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection