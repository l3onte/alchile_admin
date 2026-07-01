<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'cash_shift_id',
        'order_number',
        'total_amount',
        'payment_amount',
        'change_amount',
        'payment_method_id',
        'status'
    ];

    protected function casts(): array
    {
        return [
            'status' => OrderStatus::class
        ];
    }

    public function cash_shift(): BelongsTo
    {
        return $this->belongsTo(CashShift::class, 'cash_shift_id');
    }

    public function payment_method(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function order_details(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function product_movements(): HasMany
    {
        return $this->hasMany(ProductMovement::class, 'order_id');
    }
}
