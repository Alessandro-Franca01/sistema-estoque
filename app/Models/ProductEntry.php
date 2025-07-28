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
        'supplier_id',
        'batch_item',
        'quantity',
        'unit_cost',
        'total_cost',
    ];

    protected $casts = [
        'unit_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'quantity' => 'integer',
    ];

    /**
     * Get the product that owns the entry.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the supplier that owns the entry.
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($entry) {
            // Calcular o custo total se não for fornecido
            if (empty($entry->total_cost) && !empty($entry->unit_cost) && !empty($entry->quantity)) {
                $entry->total_cost = $entry->unit_cost * $entry->quantity;
            }
        });

        static::created(function ($entry) {
            // Atualizar o estoque do produto
            $product = $entry->product;
            $product->stock_quantity += $entry->quantity;
            $product->save();
        });
    }
}
