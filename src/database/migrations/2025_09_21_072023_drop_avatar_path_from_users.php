<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasColumn('users', 'avatar_path')) {
            Schema::table('users', function (Blueprint $t) {
                $t->dropColumn('avatar_path');
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasColumn('users', 'avatar_path')) {
            Schema::table('users', function (Blueprint $t) {
                $t->string('avatar_path')->nullable()->after('password');
            });
        }
    }
};
