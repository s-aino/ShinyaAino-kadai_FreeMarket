<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Address extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'postal_code', 'address'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // 配送先として使われた注文
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
