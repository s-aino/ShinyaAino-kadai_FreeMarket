<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'category_id', 'title', 'price', 'description'];
    protected $casts = [
        'price' => 'integer',   // DBがINT想定。DECIMALなら 'decimal:2' 等に
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);        // 外部キーが seller_id なら第2引数で 'seller_id'
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);    // 外部キー名が違うなら同様に指定
    }

    public function images(): HasMany
    {
        return $this->hasMany(ItemImage::class);     // item_images.item_id を前提
    }
}
