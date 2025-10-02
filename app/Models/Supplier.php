<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'legal_name',
        'trade_name',
        'cnpj',
        'state_registration',
        'municipal_registration',
        'email',
        'phone',
        'active',
        'observation',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Scope para fornecedores ativos
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Retorna o nome formatado do fornecedor
     * Ajustado para usar 'legal_name' em vez de 'company_name'
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->trade_name ?: $this->legal_name;
    }

    /**
     * Tenant: Departamento ao qual o fornecedor pertence.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
