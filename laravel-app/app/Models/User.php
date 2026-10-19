<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Fields that can be saved through the model.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Fields hidden when the model is converted to an array.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Data types and password hashing.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * One user can own one portfolio.
     */
    public function portfolio(): HasOne
    {
        return $this->hasOne(Portfolio::class);
    }
}