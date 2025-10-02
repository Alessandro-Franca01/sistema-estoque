<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sigla',
        'description',
        'cep',
        'address',
        'address_number',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Servidores públicos vinculados ao departamento (pivot: public_servant_departments).
     */
    public function publicServants(): BelongsToMany
    {
        return $this->belongsToMany(PublicServant::class, 'public_servant_departments')
            ->withPivot(['position', 'job_function', 'is_active'])
            ->withTimestamps();
    }

    /**
     * Apenas vínculos ativos.
     */
    public function activePublicServants(): BelongsToMany
    {
        return $this->publicServants()->wherePivot('is_active', true);
    }

    /**
     * Escopo: apenas departamentos ativos.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
