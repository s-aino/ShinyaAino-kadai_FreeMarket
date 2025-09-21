<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password'];
    protected $hidden   = ['password', 'remember_token'];
    protected $casts    = ['email_verified_at' => 'datetime'];

    public function items()
    {
        return $this->hasMany(Item::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'buyer_id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
