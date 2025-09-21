<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    // 単品購入：qty/ordered_at を持つ。payment_method は外す
    protected $fillable = [
        'buyer_id',
        'item_id',
        'address_id',
        'price',
        'qty',
        'status',
        'ordered_at',
    ];
    protected $casts = [
        'price'      => 'integer',
        'qty'        => 'integer',
        'ordered_at' => 'datetime',
    ];

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
