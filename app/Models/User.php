<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Role;
use App\Models\Cart;

class User extends Authenticatable
{
    use Notifiable, HasFactory;

    protected $fillable = [
        'role_id',
        'name',
        'email',
        'password',
        'phoneNumber',
        'image_user',
        'address',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Quan hệ: User thuộc về 1 Role
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    /**
     * Quan hệ: User có 1 giỏ hàng
     */
    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class);
    }
}
