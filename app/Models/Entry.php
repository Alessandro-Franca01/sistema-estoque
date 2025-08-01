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
        'is_existing',
        'invoice_number',
        'contract_number',
        'batch_number',
        'value',
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

    /*
    public function productEntries()
    {
        return $this->belongsToMany(ProductEntry::class, 'product_entries')
            ->withPivot(['batch_number', 'quantity', 'unit_cost', 'total_cost']);
    }
    */
}
