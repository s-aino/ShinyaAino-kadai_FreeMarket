<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    use HasFactory;

    // ここは“重複しない拡張情報”だけにするのがスッキリ
    protected $fillable = [
        'user_id',
        'display_name',  // 任意の表示名（20文字以内推奨）
        'bio',           // 自己紹介（～255）
        'website_url',   // 任意
        'birthdate',     // 任意
    ];

    protected $casts = [
        'birthdate' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
