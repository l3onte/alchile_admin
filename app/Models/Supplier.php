<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_name',
        'name',
        'phone',
        'email',
        'is_active',
        'avatar_url'
    ];

    public function supplies(): HasMany 
    {
        return $this->hasMany(Supply::class, 'supplier_id');
    }

    public function supply_purchase_histories(): HasMany
    {
        return $this->hasMany(SupplyPurchaseHistory::class, 'supplier_id');
    }
}
