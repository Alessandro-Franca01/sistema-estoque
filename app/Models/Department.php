<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    /**
     * Multi-tenant: entidades pertencentes ao Departamento (tenant).
     */
    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function suppliers(): HasMany
    {
        return $this->hasMany(Supplier::class);
    }

    public function entries(): HasMany
    {
        return $this->hasMany(Entry::class);
    }

    public function outputs(): HasMany
    {
        return $this->hasMany(Output::class);
    }

    public function calls(): HasMany
    {
        return $this->hasMany(Call::class);
    }

    public function inventories(): HasMany
    {
        return $this->hasMany(Inventory::class);
    }
}
