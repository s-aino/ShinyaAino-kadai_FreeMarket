<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        /**
         * 1) items に単一画像カラムを追加（無ければ）
         */
        if (!Schema::hasColumn('items', 'image_path')) {
            Schema::table('items', function (Blueprint $t) {
                // status の後ろに入れたいだけなので位置指定。存在しなくても問題はありません。
                $t->string('image_path')->nullable()->after('status');
            });
        }

        /**
         * 2) orders を「単品購入」仕様に統合
         *   - orders が無い環境でも動くように、無ければ作成／あれば不足分を追加
         */
        if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $t) {
                $t->id();
                $t->foreignId('buyer_id')->constrained('users')->cascadeOnDelete();
                $t->foreignId('item_id')->constrained('items')->cascadeOnDelete();
                $t->unsignedInteger('price');
                $t->unsignedInteger('qty')->default(1);
                $t->string('status', 12)->default('pending');
                $t->timestamp('ordered_at')->nullable();

                // addresses がまだ無い環境でも落ちないよう、まずは生の id として持つ
                $t->unsignedBigInteger('address_id')->nullable();

                $t->timestamps();
            });

            // addresses が既にあるなら FK を後付け
            if (Schema::hasTable('addresses')) {
                Schema::table('orders', function (Blueprint $t) {
                    $t->foreign('address_id')
                        ->references('id')->on('addresses')
                        ->nullOnDelete();
                });
            }
        } else {
            Schema::table('orders', function (Blueprint $t) {
                if (!Schema::hasColumn('orders', 'item_id')) {
                    $t->foreignId('item_id')->constrained('items')->cascadeOnDelete()->after('buyer_id');
                }
                if (!Schema::hasColumn('orders', 'price')) {
                    $t->unsignedInteger('price')->after('item_id');
                }
                if (!Schema::hasColumn('orders', 'qty')) {
                    $t->unsignedInteger('qty')->default(1)->after('price');
                }
                if (!Schema::hasColumn('orders', 'status')) {
                    $t->string('status', 12)->default('pending')->after('qty');
                }
                if (!Schema::hasColumn('orders', 'ordered_at')) {
                    $t->timestamp('ordered_at')->nullable()->after('status');
                }
                if (!Schema::hasColumn('orders', 'address_id')) {
                    $t->unsignedBigInteger('address_id')->nullable()->after('ordered_at');
                }
                // 以前の合計カラムがある場合はシンプル化のため削除
                if (Schema::hasColumn('orders', 'total_amount')) {
                    $t->dropColumn('total_amount');
                }
            });

            // addresses があれば FK を付与（既に付いてても二重にはならない DB が多いですが、簡易対応）
            if (Schema::hasTable('addresses')) {
                Schema::table('orders', function (Blueprint $t) {
                    // 外部キーが既にあるかを厳密チェックせず、無ければ付く挙動に任せます
                    $t->foreign('address_id')
                        ->references('id')->on('addresses')
                        ->nullOnDelete();
                });
            }
        }

        /**
         * 3) 不要テーブルを削除
         */
        foreach (['profiles', 'favorites', 'order_items', 'item_images'] as $table) {
            if (Schema::hasTable($table)) {
                Schema::drop($table);
            }
        }

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        /**
         * 1) 可能な範囲で元に戻す（簡易リストア）
         */

        // order_items を最小定義で復元
        if (!Schema::hasTable('order_items')) {
            Schema::create('order_items', function (Blueprint $t) {
                $t->id();
                $t->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
                $t->foreignId('item_id')->constrained('items')->cascadeOnDelete();
                $t->unsignedInteger('price');
                $t->unsignedInteger('qty');
                $t->timestamps();
            });
        }

        // item_images を最小定義で復元
        if (!Schema::hasTable('item_images')) {
            Schema::create('item_images', function (Blueprint $t) {
                $t->id();
                $t->foreignId('item_id')->constrained('items')->cascadeOnDelete();
                $t->string('path');
                $t->unsignedSmallInteger('sort_order')->default(0);
                $t->timestamps();
            });
        }

        // favorites を最小定義で復元
        if (!Schema::hasTable('favorites')) {
            Schema::create('favorites', function (Blueprint $t) {
                $t->id();
                $t->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $t->foreignId('item_id')->constrained('items')->cascadeOnDelete();
                $t->timestamps();
                $t->unique(['user_id', 'item_id']);
            });
        }

        // profiles を最小定義で復元
        if (!Schema::hasTable('profiles')) {
            Schema::create('profiles', function (Blueprint $t) {
                $t->id();
                $t->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
                $t->string('display_name', 20)->nullable();
                $t->string('bio', 255)->nullable();
                $t->timestamps();
            });
        }

        // orders から今回追加した列を外し、total_amount を戻す
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $t) {
                // 先に外部キーを落とす必要がある場合に備えて順序に注意
                if (Schema::hasColumn('orders', 'address_id')) {
                    // 明示的に外部キー名が分からないので配列指定で drop
                    try {
                        $t->dropForeign(['address_id']);
                    } catch (\Throwable $e) {
                    }
                }
                if (Schema::hasColumn('orders', 'item_id')) {
                    // Laravel 9+ なら dropConstrainedForeignId が使える
                    try {
                        $t->dropConstrainedForeignId('item_id');
                    } catch (\Throwable $e) {
                        try {
                            $t->dropForeign(['item_id']);
                        } catch (\Throwable $e2) {
                        }
                        try {
                            $t->dropColumn('item_id');
                        } catch (\Throwable $e3) {
                        }
                    }
                }
                foreach (['price', 'qty', 'status', 'ordered_at', 'address_id'] as $col) {
                    if (Schema::hasColumn('orders', $col)) {
                        try {
                            $t->dropColumn($col);
                        } catch (\Throwable $e) {
                        }
                    }
                }
                if (!Schema::hasColumn('orders', 'total_amount')) {
                    $t->unsignedInteger('total_amount')->nullable();
                }
            });
        }

        // items から image_path を削除
        if (Schema::hasColumn('items', 'image_path')) {
            Schema::table('items', function (Blueprint $t) {
                $t->dropColumn('image_path');
            });
        }

        Schema::enableForeignKeyConstraints();
    }
};
