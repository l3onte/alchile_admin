<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [ 
        'user_id',
        'name',
        'last_name',
        'address',
        'phone',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function invoices() {
        return $this->hasMany(Invoice::class);
    }

    public function getFullNameAttribute() {
        return "{$this->name} {$this->last_name}";
    }
}
