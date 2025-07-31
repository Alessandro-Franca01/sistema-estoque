<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemInventory extends Model
{
    protected $fillable = [
        'inventory_id',
        'product_id',
        'register_amount',
        'real_amount',
        'difference',
        'observations',
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
