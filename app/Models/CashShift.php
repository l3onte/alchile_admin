<?php

namespace App\Models;

use App\Enums\CashShiftStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CashShift extends Model
{
    use HasFactory;

    protected $fillable = [
        'cash_register_id',
        'user_id',
        'opening_cash',
        'closing_cash_estimated',
        'closing_cash_real',
        'status',
        'opened_at',
        'closed_at'
    ];

    protected function casts(): array
    {
        return [
            'status' => CashShiftStatus::class,
            'opened_at' => 'datetime',
            'closed_at' => 'datetime'
        ];
    }

    public function cash_register(): BelongsTo 
    {
        return $this->belongsTo(CashRegister::class, 'cash_register_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cash_transactions(): HasMany
    {
        return $this->hasMany(CashTransaction::class, 'cash_shift_id');
    } 

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'cash_shift_id');
    }
}
