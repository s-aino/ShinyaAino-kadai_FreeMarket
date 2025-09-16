<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('users')->updateOrInsert(
            ['email' => 'test@example.com'],
            ['name' => 'テストユーザー', 'password' => Hash::make('password'), 'created_at' => now(), 'updated_at' => now()]
        );
    }
}
