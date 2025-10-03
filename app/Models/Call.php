<?php

namespace App\Models;

use App\Models\Concerns\TenantScoped;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Call extends Model
{
    use HasFactory, TenantScoped;

    protected $fillable = [
        'type',
        'service_order',
        'connect_code',
        'phone',
        'applicant',
        'destination',
        'cep',
        'complement',
        'status',
        'observation',
        'output_id',
        'memorandum_1doc',
    ];

    // Tipos de chamado
    const CALL_TYPE_WHATSAPP = 'whatssap';
    const CALL_TYPE_CONECTAR_CABEDELO = 'conectar_cabedelo';
    const CALL_TYPE_PERSONALLY = 'personally';
    const CALL_TYPE_PHONE = 'phone';
    const CALL_TYPE_OTHER = 'other';

    // Status
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_FINISHED = 'finished';
    const STATUS_CANCELLED = 'cancelled';

    public function output(): BelongsTo
    {
        return $this->belongsTo(Output::class);
    }

    /**
     * Tenant: Departamento ao qual o chamado pertence.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
