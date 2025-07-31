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
        'observation'
    ];

    protected $casts = [
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
}