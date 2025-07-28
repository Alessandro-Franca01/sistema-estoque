<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'quantity',
        'observation',
        'is_active',
        'category_id',
        'measurement_types_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'quantity' => 'integer',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();
    }

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function measurementType()
    {
        return $this->belongsTo(MeasurementType::class, 'measurement_types_id');
    }

    /**
     * Get the supplier that owns the product.
     */
    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class, 'supplier_products')
            ->withTimestamps();
    }

    public function entries()
    {
        return $this->belongsToMany(Entry::class, 'product_entries')
            ->withPivot(['batch_number', 'quantity', 'unit_cost', 'total_cost']);
    }

    public function outputs()
    {
        return $this->belongsToMany(Output::class, 'products_output')
            ->withPivot(['quantity', 'quantity_used', 'quantity_returned', 'is_finished']);
    }

    /**
     * Check if the product is in stock.
     */
    public function getIsInStockAttribute(): bool
    {
        return !$this->manage_stock || $this->stock_quantity > 0;
    }

    /**
     * Scope a query to only include active products.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include products in stock.
     */
    public function scopeInStock($query)
    {
        return $query->where(function ($q) {
            $q->where('manage_stock', false)
              ->orWhere('stock_quantity', '>', 0);
        });
    }
}
