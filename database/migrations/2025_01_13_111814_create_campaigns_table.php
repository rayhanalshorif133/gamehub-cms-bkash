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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('banner', 255)->nullable();
            $table->unsignedBigInteger('game_id')->nullable();
            $table->unsignedBigInteger('prize_id')->nullable();
            $table->string('game_keyword', 255)->nullable();
            $table->double('amount', 8, 2)->nullable();
            $table->integer('gift_amount')->default(0);
            $table->integer('participation')->default(0);
            $table->string('subs_validity', 255)->default('NULL');
            $table->string('prize_description', 255)->default('NULL');
            $table->string('score_count_type', 100)->default('MAX');
            $table->date('start_date')->nullable();
            $table->time('start_time')->nullable();
            $table->date('end_date')->nullable();
            $table->time('end_time')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->text('description')->nullable();
            $table->string('time_status', 255)->nullable();
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
        Schema::dropIfExists('campaigns');
    }
};
