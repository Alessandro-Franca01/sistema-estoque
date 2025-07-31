<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Output extends Model
{
    use HasFactory;

    protected $table = 'outputs';

    protected $fillable = [
        'connect_code',
        'output_date',
        'call_type',
        'status',
        'whatsapp_number',
        'caller_name',
        'observation',
        'destination',
        'public_servant_id'
    ];

    protected $casts = [
        'output_date' => 'datetime',
    ];

    // Tipos de chamado
    const CALL_TYPE_WHATSAPP = 'whatssap';
    const CALL_TYPE_CONECTAR_CABEDELO = 'conectar_cabedelo';
    const CALL_TYPE_PERSONALLY = 'personally';
    const CALL_TYPE_PHONE = 'phone';
    const CALL_TYPE_OTHER = 'other';

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
}