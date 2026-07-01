<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupplyPurchaseHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'supply_id',
        'supplier_id',
        'quantity_purchased',
        'unit_cost_paid',
        'purchased_at'
    ];

    protected function casts(): array
    {
        return [
            'purchased_at' => 'datetime',
        ];
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function supply(): BelongsTo
    {
        return $this->belongsTo(Supply::class, 'supply_id');
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}
