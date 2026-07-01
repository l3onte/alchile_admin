<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_reventa',
        'status'
    ];

    protected function casts(): array
    {
        return [
            'is_reventa' => 'boolean',
            'status'    => 'boolean',
        ];
    }   

    public function branch_products(): HasMany
    {
        return $this->hasMany(BranchProduct::class, 'product_id');
    }

    public function recipe_details(): HasMany
    {
        return $this->hasMany(RecipeDetail::class, 'product_id');
    }

    public function order_details(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'product_id');
    }

    public function product_movements(): HasMany
    {
        return $this->hasMany(ProductMovement::class, 'product_id');
    }
}
