<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'id_category',
        'sku',
        'name',
        'type',
        'purchase_price',
        'sell_price',
        'unit',
        'edited_by',
        'expiration_date'
    ];

    public function category() {
        return $this->belongsTo(ProductCategory::class, 'id_category');   
    }

    public function editor() {
        return $this->belongsTo(User::class, 'edited_by');
    }

    public function recipe() {
        return $this->hasOne(Recipe::class);
    }
}
