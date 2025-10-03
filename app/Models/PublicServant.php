<?php

namespace App\Models;

use App\Models\Concerns\TenantScoped;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PublicServant extends Model
{
    protected $fillable = [
        'name',
        'registration',
        'cpf',
        'email',
        'phone',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Departamentos vinculados ao servidor público (pivot: public_servant_departments).
     */
    public function departments(): BelongsToMany
    {
        return $this->belongsToMany(Department::class, 'public_servant_departments')
            ->withPivot(['position', 'job_function', 'is_active'])
            ->withTimestamps();
    }

    /**
     * Apenas vínculos ativos do servidor com departamentos.
     */
    public function activeDepartments(): BelongsToMany
    {
        return $this->departments()->wherePivot('is_active', true);
    }
}
