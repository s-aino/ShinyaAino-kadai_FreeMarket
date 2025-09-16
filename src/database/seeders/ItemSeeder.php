<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    private function catId(string $name): int
    {
        return (int) (DB::table('categories')->where('name', $name)->value('id') ?? 1);
    }

    private function cond(string $txt): int
    {
        return [
            '新品' => 0,
            '美品' => 1,
            '良品' => 2,
            'やや傷や汚れあり' => 3,
            '状態が悪い' => 4,
            '良好' => 1,
            '目立った傷や汚れなし' => 1,
        ][$txt] ?? 2;
    }

    public function run(): void
    {
        // ← TestUserSeeder で作ったユーザーIDを取得（既存DBでも安全）
        $userId = (int) (DB::table('users')->where('email', 'test@example.com')->value('id') ?? 1);

        $rows = [
            ['title'=>'腕時計','price'=>15000,'brand'=>'Rolax','desc'=>'スタイリッシュな腕時計','img'=>'https://picsum.photos/seed/watch/600/400','cond'=>'良好','cat'=>'ファッション'],
            ['title'=>'HDD','price'=>3000,'brand'=>'西芝','desc'=>'高速で信頼性の高いHDD','img'=>'httpsum.photos/seed/hdd/600/400','cond'=>'目立った傷や汚れなし','cat'=>'家電'],
        ];

        foreach ($rows as $r) {
            $itemId = DB::table('items')->insertGetId([
                'user_id'     => $userId,
                'category_id' => $this->catId($r['cat']),
                'title'       => $r['title'],
                'description' => $r['desc'],
                'price'       => $r['price'],
                'condition'   => $this->cond($r['cond']),
                'status'      => 1,
                'brand'       => $r['brand'],
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);

            DB::table('item_images')->insert([
                'item_id'    => $itemId,
                'path'       => $r['img'],   // いまはURL直格納。後で storage:link に切替OK
                'sort_order' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
