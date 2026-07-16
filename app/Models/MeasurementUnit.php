<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MeasurementUnit extends Model
{
    use HasFactory;

    protected $fillable = [
        'avatar_url',
        'name',
        'abbreviation',
        'is_active'
    ];  

    public function supplies(): HasMany
    {
        return $this->hasMany(Supply::class, 'measurement_unit_id');
    }
}
