<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Waste extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'branch_id',
        'supply_id',
        'quantity',
        'cost_lost',
        'reason'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function supply(): BelongsTo
    {
        return $this->belongsTo(Supply::class, 'supply_id');
    }
}
