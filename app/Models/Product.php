<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'quantity',
        'meansurement_unit',
        'observation',
        'is_active',
        'category_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // static::creating(function ($product) {
        // });

        // static::updating(function ($product) {
        // });
    }

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the product entries for the product.
     */
    public function productEntries(): HasMany
    {
        return $this->hasMany(ProductEntry::class);
    }

    public function productOutputs(): HasMany
    {
        return $this->hasMany(ProductOutput::class);
    }

    /**
     * Check if the product is in stock.
     */
    public function getIsInStockAttribute(): bool
    {
        return $this->quantity > 0;
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
        return $query->where('quantity', '>', 0);
    }
}