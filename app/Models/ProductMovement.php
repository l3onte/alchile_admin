<?php

namespace App\Models;

use App\Enums\ProductMovementType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'branch_id',
        'product_id',
        'order_id',
        'quantity',
        'movement_type',
        'description'
    ];

    protected function casts() : array
    {
        return [
            'movement_type' => ProductMovementType::class
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

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
