<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOutput extends Model
{
    use HasFactory;

    protected $table = 'products_output';

    protected $fillable = [
        'product_id',
        'output_id',
        'quantity',
        'quantity_used',
        'quantity_returned',
        'is_finished',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'quantity_used' => 'integer',
        'quantity_returned' => 'integer',
        'is_finished' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function output()
    {
        return $this->belongsTo(Output::class);
    }

    /**
     * Get the write-off quantity for the product output.
     */
    public function getWriteOffQuantityAttribute(): int
    {
        return $this->quantity - ($this->quantity_used + $this->quantity_returned);
    }
} 