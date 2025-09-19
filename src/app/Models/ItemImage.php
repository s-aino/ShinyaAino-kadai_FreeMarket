<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemImage extends Model
{
    use HasFactory;

    // 例: path(画像パス) or filename(ファイル名) を想定
    protected $fillable = ['item_id', 'path'];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
