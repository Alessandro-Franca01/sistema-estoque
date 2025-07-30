<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'entry_id',
        'batch_item',
        'quantity',
        'unit_cost',
        'total_cost',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function entry(): BelongsTo
    {
        return $this->belongsTo(Entry::class);
    }
}
