<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
Schema::create('addresses', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->string('postal_code', 10);
    $table->string('prefecture', 50);
    $table->string('city', 100);
    $table->string('address_line1', 255);
    $table->string('address_line2', 255)->nullable();
    $table->boolean('is_default')->default(false);
    $table->timestamps();
    $table->index(['user_id','is_default']);
});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
