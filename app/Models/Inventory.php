<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\TenantScoped;

class Inventory extends Model
{
    use HasFactory, TenantScoped;

    protected $fillable = [
        'start_date',
        'end_date',
        'status',
        'user_id',
        'observations',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(ItemInventory::class);
    }

    /**
     * Tenant: Departamento ao qual o inventário pertence.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
