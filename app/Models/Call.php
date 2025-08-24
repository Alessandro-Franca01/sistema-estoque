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
        'applicant',
        'destination',
        'cep',
        'complement',
        'observation',
        'output_id',
    ];

    // Tipos de chamado
    const CALL_TYPE_WHATSAPP = 'whatssap';
    const CALL_TYPE_CONECTAR_CABEDELO = 'conectar_cabedelo';
    const CALL_TYPE_PERSONALLY = 'personally';
    const CALL_TYPE_PHONE = 'phone';
    const CALL_TYPE_OTHER = 'other';

    public function output(): BelongsTo
    {
        return $this->belongsTo(Output::class);
    }
}
