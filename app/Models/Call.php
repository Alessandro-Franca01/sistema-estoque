<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Call extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'service_order',
        'connect_code',
        'phone',
        'caller_name',
        'observation',
        'output_id',
    ];

    public function output(): BelongsTo
    {
        return $this->belongsTo(Output::class);
    }
}