<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        'admin_id',
        'name',
        'phone',
        'address'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'admin_id');
    }

    
}
