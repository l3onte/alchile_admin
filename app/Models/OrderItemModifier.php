<?php

namespace App\Models;

use App\Enums\OrderModifierAction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItemModifier extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_detail_id',
        'supply_id',
        'action',
        'extra_price'
    ];

    protected function casts() : array
    {
        return [
            'action' => OrderModifierAction::class
        ];
    }

    public function order_detail(): BelongsTo
    {
        return $this->belongsTo(OrderDetail::class, 'order_detail_id');
    }

    public function supply(): BelongsTo
    {
        return $this->belongsTo(Supply::class, 'supply_id');
    }
}
