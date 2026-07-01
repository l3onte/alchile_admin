<?php

namespace App\Models;

use App\Enums\CashTransactionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CashTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'cash_shift_id',
        'type',
        'amount',
        'description'
    ];

    protected function casts() : array
    {
        return [
            'type' => CashTransactionType::class
        ];
    }

    public function cash_shift(): BelongsTo
    {
        return $this->belongsTo(CashShift::class, 'cash_shift_id');
    }
}
