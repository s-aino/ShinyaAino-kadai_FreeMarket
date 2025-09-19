<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // 1:1 (任意で作る場合)
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    // 1:多
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    // 1:多（出品）
    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    // 多:多（お気に入り）
    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'favorites')->withTimestamps();
    }

    // 1:多（購入）
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'buyer_id');
    }

    // 1:多（コメント）
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
