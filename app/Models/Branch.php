<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'branch_name',
        'location',
        'is_active'
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function branch_supplies(): HasMany
    {
        return $this->hasMany(BranchSupply::class, 'branch_id');
    }

    public function branch_products(): HasMany
    {
        return $this->hasMany(BranchProduct::class, 'branch_id');
    }

    public function cash_registers(): HasMany
    {
        return $this->hasMany(CashRegister::class, 'branch_id');
    }

    public function product_movements(): HasMany
    {
        return $this->hasMany(ProductMovement::class, 'branch_id');
    }

    public function supply_movements(): HasMany
    {
        return $this->hasMany(SupplyMovement::class, 'branch_id');
    }

    public function wastes(): HasMany
    {
        return $this->hasMany(Waste::class, 'branch_id');
    }

    public function supply_purchase_histories(): HasMany
    {
        return $this->hasMany(SupplyPurchaseHistory::class, 'branch_id');
    }
}
