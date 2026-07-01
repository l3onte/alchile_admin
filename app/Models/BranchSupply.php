<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Branch;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BranchSupply extends Model
{
    use HasFactory;

    protected $fillable = [
        'supply_id',
        'branch_id',
        'quantity',
        'unit_cost',
        'min_stock'
    ];

    public function supply(): BelongsTo
    {
        return $this->belongsTo(Supply::class, 'supply_id');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
}
