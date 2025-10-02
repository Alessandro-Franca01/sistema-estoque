<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'entry_date',
        'observation',
        'invoice_number',
        'contract_number',
        'batch_number',
        'value',
        'entry_type',
    ];

    // Types
    const TYPE_PURCHASED = 'purchased';
    const TYPE_FEEDING = 'feeding';
    const TYPE_REVERSAL = 'reversal';

    protected $casts = [
        'entry_date' => 'datetime',
        'value' => 'decimal:2',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_entries')
            ->withPivot(['batch_item', 'quantity', 'unit_cost', 'total_cost']);
    }

    /**
     * Tenant: Departamento ao qual a entrada pertence.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /*
    public function productEntries()
    {
        return $this->belongsToMany(ProductEntry::class, 'product_entries')
            ->withPivot(['batch_number', 'quantity', 'unit_cost', 'total_cost']);
    }
    */
}
