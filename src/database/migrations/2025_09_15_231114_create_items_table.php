<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();       // 出品者
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('title', 100);
            $table->text('description');
            $table->unsignedInteger('price');                                     // 円（整数）
            $table->unsignedTinyInteger('condition')->default(0);                 // 0..4
            $table->unsignedTinyInteger('status')->default(1);                    // 0:下書 1:公開 2:売却
            $table->string('brand', 50)->nullable();
            $table->timestamps();
            $table->index(['status', 'created_at']);
            $table->index(['category_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
