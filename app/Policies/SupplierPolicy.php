<?php

namespace App\Policies;

use App\Models\Supplier;
use App\Models\User;

class SupplierPolicy
{
    /**
     * Administrativos e almoxarifes podem listar/visualizar.
     */
    public function viewAny(?User $user): bool
    {
        return (bool) ($user?->hasAnyRole(['administrativo', 'almoxarife']));
    }

    public function view(?User $user, Supplier $supplier): bool
    {
        return (bool) ($user?->hasAnyRole(['administrativo', 'almoxarife']));
    }

    /**
     * Apenas administrativos podem criar.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('administrativo');
    }

    /**
     * Apenas administrativos podem editar/atualizar.
     */
    public function update(User $user, Supplier $supplier): bool
    {
        return $user->hasRole('administrativo');
    }

    /**
     * Exclusão não é permitida.
     */
    public function delete(User $user, Supplier $supplier): bool
    {
        return false;
    }

    public function restore(User $user, Supplier $supplier): bool
    {
        return false;
    }

    public function forceDelete(User $user, Supplier $supplier): bool
    {
        return false;
    }

    /**
     * Somente administrativos podem desativar (alterar o campo active).
     */
    public function deactivate(User $user, Supplier $supplier): bool
    {
        return $user->hasRole('administrativo');
    }
}
