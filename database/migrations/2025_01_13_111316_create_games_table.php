<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('banner', 255);
            $table->string('icon', 255)->nullable();
            $table->string('card_bg_image', 255)->nullable();
            $table->string('bg_color', 255)->nullable();
            $table->string('description', 255)->nullable();
            $table->string('keyword', 255)->unique();
            $table->integer('attempt')->default(0);
            $table->string('url', 255)->nullable();
            $table->bigInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
};
