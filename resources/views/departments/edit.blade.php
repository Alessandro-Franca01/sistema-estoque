@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Editar Departamento: {{ $department->name }}</span>
                        <a href="{{ route('departments.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Voltar
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('departments.update', $department) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nome do Departamento *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $department->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sigla" class="form-label">Sigla *</label>
                                    <input type="text" class="form-control @error('sigla') is-invalid @enderror" 
                                           id="sigla" name="sigla" value="{{ old('sigla', $department->sigla) }}" required>
                                    @error('sigla')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cep" class="form-label">CEP *</label>
                                    <input type="text" class="form-control cep @error('cep') is-invalid @enderror" 
                                           id="cep" name="cep" value="{{ old('cep', $department->cep) }}" required>
                                    @error('cep')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Endereço *</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" 
                                   id="address" name="address" value="{{ old('address', $department->address) }}" required>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="address_number" class="form-label">Número *</label>
                                    <input type="text" class="form-control @error('address_number') is-invalid @enderror" 
                                           id="address_number" name="address_number" value="{{ old('address_number', $department->address_number) }}" required>
                                    @error('address_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="is_active" class="form-label">Status</label>
                                    <select class="form-select @error('is_active') is-invalid @enderror" 
                                            id="is_active" name="is_active">
                                        <option value="1" {{ old('is_active', $department->is_active) == 1 ? 'selected' : '' }}>Ativo</option>
                                        <option value="0" {{ old('is_active', $department->is_active) == 0 ? 'selected' : '' }}>Inativo</option>
                                    </select>
                                    @error('is_active')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Descrição</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3">{{ old('description', $department->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-between">
                            <button type="button" class="btn btn-danger" 
                                    onclick="if(confirm('Tem certeza que deseja excluir este departamento?')) { document.getElementById('delete-form').submit(); }">
                                <i class="fas fa-trash"></i> Excluir
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Atualizar
                            </button>
                        </div>
                    </form>

                    <form id="delete-form" action="{{ route('departments.destroy', $department) }}" method="POST" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Máscara para CEP
    document.addEventListener('DOMContentLoaded', function() {
        const cepInput = document.getElementById('cep');
        
        if (cepInput) {
            cepInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 5) {
                    value = value.substring(0, 5) + '-' + value.substring(5, 8);
                }
                e.target.value = value;
            });
        }
    });
</script>
@endpush

@endsection
