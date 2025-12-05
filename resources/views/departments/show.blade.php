@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Detalhes do Departamento</span>
                        <div>
                            <a href="{{ route('departments.edit', $department) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <a href="{{ route('departments.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Voltar
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h4 class="mb-4">{{ $department->name }} ({{ $department->sigla }})</h4>
                            
                            <div class="mb-3">
                                <h6 class="text-muted mb-1">Status</h6>
                                <span class="badge bg-{{ $department->is_active ? 'success' : 'secondary' }}">
                                    {{ $department->is_active ? 'Ativo' : 'Inativo' }}
                                </span>
                            </div>

                            @if($department->description)
                                <div class="mb-3">
                                    <h6 class="text-muted mb-1">Descrição</h6>
                                    <p class="mb-0">{{ $department->description }}</p>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-6">
                            <div class="card border-0 bg-light">
                                <div class="card-body">
                                    <h5 class="card-title">Endereço</h5>
                                    <address class="mb-0">
                                        {{ $department->address }}, {{ $department->address_number }}<br>
                                        CEP: {{ $department->cep }}<br>
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($department->publicServants->count() > 0)
                        <div class="mt-4">
                            <h5 class="mb-3">Servidores Vinculados</h5>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nome</th>
                                            <th>Cargo</th>
                                            <th>Função</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($department->publicServants as $servant)
                                            <tr>
                                                <td>{{ $servant->name }}</td>
                                                <td>{{ $servant->pivot->position ?? 'Não informado' }}</td>
                                                <td>{{ $servant->pivot->job_function ?? 'Não informada' }}</td>
                                                <td>
                                                    @php
                                                        $isActive = $servant->pivot->is_active ?? true;
                                                    @endphp
                                                    <span class="badge bg-{{ $isActive ? 'success' : 'secondary' }}">
                                                        {{ $isActive ? 'Ativo' : 'Inativo' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="card-footer text-muted">
                    <small>
                        Criado em: {{ $department->created_at->format('d/m/Y H:i') }} | 
                        Atualizado em: {{ $department->updated_at->format('d/m/Y H:i') }}
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
