@extends('layouts.app')

@section('title', 'Chamados')

@section('content')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('calls.create') }}" class="btn btn-primary">Create New Call</a>
                    </div>
                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Type</th>
                                <th class="px-4 py-2">Caller Name</th>
                                <th class="px-4 py-2">Phone</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($calls as $call)
                                <tr>
                                    <td class="border px-4 py-2">{{ $call->type }}</td>
                                    <td class="border px-4 py-2">{{ $call->caller_name }}</td>
                                    <td class="border px-4 py-2">{{ $call->phone }}</td>
                                    <td class="border px-4 py-2">
                                        <a href="{{ route('calls.show', $call) }}" class="btn btn-info">View</a>
                                        <a href="{{ route('calls.edit', $call) }}" class="btn btn-warning">Edit</a>
                                        <form action="{{ route('calls.destroy', $call) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $calls->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection