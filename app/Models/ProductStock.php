<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    protected $table = 'product_stock';

    protected $fillable = [
        'branch_id',
        'product_id',
        'quantity',
        'purchase_price',
        'expiration_date'
    ];

    public function branch() {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
