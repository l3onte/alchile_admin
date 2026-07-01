<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supply extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'name',
        'measurement_unit_id',
        'status'
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function measurement_unit(): BelongsTo
    {
        return $this->belongsTo(MeasurementUnit::class, 'measurement_unit_id');
    }

    public function branch_supplies(): HasMany
    {
        return $this->hasMany(BranchSupply::class, 'supply_id');
    }

    public function recipe_details(): HasMany
    {
        return $this->hasMany(RecipeDetail::class, 'supply_id');
    }

    public function order_item_modifiers(): HasMany
    {
        return $this->hasMany(OrderItemModifier::class, 'supply_id');
    }

    public function supply_movements(): HasMany
    {
        return $this->hasMany(SupplyMovement::class, 'supply_id');
    }

    public function wastes(): HasMany
    {
        return $this->hasMany(Waste::class, 'supply_id');
    }

    public function supply_purchase_histories(): HasMany
    {
        return $this->hasMany(SupplyPurchaseHistory::class, 'supply_id');
    }
}