<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Output extends Model
{
    use HasFactory;

    protected $table = 'outputs';

    protected $fillable = [
        'output_date',
        'cep',
        'complement',
        'status',
        'observation',
        'destination',
        'is_active',
        'public_servant_id'
    ];

    protected $casts = [
        'output_date' => 'datetime',
    ];

    // Status
    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELED = 'canceled';

    public function publicServant()
    {
        return $this->belongsTo(PublicServant::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_outputs')
            ->withPivot('quantity', 'quantity_used', 'quantity_returned', 'is_finished', 'observation');
    }

    public function calls()
    {
        return $this->hasMany(Call::class);
    }
}
