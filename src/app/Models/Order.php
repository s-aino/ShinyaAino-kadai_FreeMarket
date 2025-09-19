<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'buyer_id',
        'item_id',
        'address_id',
        'price',
        'payment_method',
        'status'
    ];

    protected $casts = ['price' => 'integer'];

    // 購入者
    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    // 単品購入型：注文された商品
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    // 送付先
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }
}
