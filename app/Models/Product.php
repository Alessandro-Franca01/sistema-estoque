<?php

namespace App\Models;

use Carbon\Carbon;
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

        static::created(function (Product $product) {
            // Gera o código apenas se não tiver sido definido manualmente
            if (empty($product->code)) {
                $product->code = self::formatGeneratedCode($product);
                // Salva sem disparar eventos
                $product->saveQuietly();
            }
        });

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
     * Tenant: Departamento proprietário do produto.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
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

    private static function formatGeneratedCode(Product $product): string
    {
        // Obtém base do prefixo: categoria ou nome do produto
        $base = optional($product->category)->name ?: $product->name;
        $baseCaracters = substr($base, 0, 3);
        // Normaliza: slug sem separadores e em maiúsculas
        $prefix = Str::upper(Str::slug((string) $baseCaracters, ''));
        // Formata o ID do produto com zeros à esquerda até ter 4 dígitos
        $formattedId = str_pad($product->id, 4, '0', STR_PAD_LEFT);

        return sprintf('%s%s', $prefix, $formattedId);
    }
}
