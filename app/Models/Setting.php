<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'bussines_name',
        'email',
        'phone',
        'address',
        'logo_path',
        'currency',
        'website'
    ];

    public static function getInfo() {
        return self::first();
    }
}
