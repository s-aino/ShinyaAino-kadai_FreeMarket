<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    // 6テーブル案は階層なし。親子をやらないので parent_id は持たない
    protected $fillable = ['name', 'slug'];

    public function items() { return $this->hasMany(Item::class); }
}
