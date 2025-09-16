<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $names = [
            'ファッション',
            '家電',
            'インテリア',
            'レディース',
            'メンズ',
            'コスメ',
            '本・ゲーム',
            'スポーツ',
            'ベビー',
            'ハンドメイド',
            'アクセサリー',
            'キッチン',
            '食品'
        ];
        foreach ($names as $i => $name) {
            DB::table('categories')->updateOrInsert(
                ['name' => $name],
                ['sort_order' => $i, 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
