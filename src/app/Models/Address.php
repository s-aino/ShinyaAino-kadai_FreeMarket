<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;

    // 仕様：postal/prefecture/city/line1/line2/phone/is_default
    protected $fillable = [
        'user_id',
        'postal',
        'prefecture',
        'city',
        'line1',
        'line2',
        'phone',
        'is_default',
    ];
    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
