<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'branch_id',
        'user_id',
        'customer_id',
        'payment_method_id',
        'status',
        'discount',
        'tax_amount',
        'total'
    ];

    public function branch() {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function payment() {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function details() {
        return $this->hasMany(InvoiceDetail::class);
    }

    public function getTotalFormattedAttribute() {
        return 'C$' . number_format($this->total, 2);
    }

    protected function casts() : array {
        return ['total' => 'decimal:2', 'discount' => 'decimal:2', 'tax_amount' => 'decimal:2'];
    }
}
