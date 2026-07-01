<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BranchProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'product_id',
        'price',
        'status'
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }   

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
