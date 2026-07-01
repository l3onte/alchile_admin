<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecipeDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'supply_id',
        'quantity'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function supply(): BelongsTo
    {
        return $this->belongsTo(Supply::class, 'supply_id');
    }
}
