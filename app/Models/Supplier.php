<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'legal_name',
        'trade_name',
        'cnpj',
        'email',
        'phone',
        'state_registration',
        'municipal_registration',
        'observation',
        'active'
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
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->trade_name ?: $this->company_name;
    }

    // Relacionamento com produtos
    public function products()
    {
        return $this->belongsToMany(Product::class, 'supplier_products')
            ->withTimestamps();
    }

    /**
     * Relacionamento com entradas
     */
    public function entries()
    {
        return $this->hasMany(Entry::class);
    }
}
