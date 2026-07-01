<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Branch;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class, 'admin_id');
    }

    public function cash_shifts(): HasMany
    {
        return $this->hasMany(CashShift::class, 'user_id');
    }

    public function product_movements(): HasMany
    {
        return $this->hasMany(ProductMovement::class, 'user_id');
    }

    public function supply_movements(): HasMany
    {
        return $this->hasMany(SupplyMovement::class, 'user_id');
    }

    public function wastes(): HasMany
    {
        return $this->hasMany(Waste::class, 'user_id');
    }
}
