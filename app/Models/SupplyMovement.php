<?php

namespace App\Models;

use App\Enums\SupplyMovementType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupplyMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'branch_id',
        'supply_id',
        'movement_type',
        'description',
        'quantity'
    ];

    protected function casts() : array
    {
        return [
            'movement_type' => SupplyMovementType::class
        ];
    }

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
