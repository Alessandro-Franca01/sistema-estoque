<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    /**
     * Qualquer usuário autenticado pode listar/visualizar.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Product $product): bool
    {
        return true;
    }

    /**
     * Apenas administrativoes podem criar.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('administrativo');
    }

    /**
     * Apenas administrativoes podem editar/atualizar.
     */
    public function update(User $user, Product $product): bool
    {
        return $user->hasRole('administrativo');
    }

    /**
     * Exclusão não é permitida.
     */
    public function delete(User $user, Product $product): bool
    {
        return false;
    }

    public function restore(User $user, Product $product): bool
    {
        return false;
    }

    public function forceDelete(User $user, Product $product): bool
    {
        return false;
    }
}
