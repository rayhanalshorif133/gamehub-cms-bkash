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
        Schema::create('game_play_logs', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('msisdn', 20);
            $table->string('keyword', 50)->nullable();
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->time('durations')->virtualAs('timediff(end_time, start_time)');
            $table->integer('score')->default(0);
            $table->string('status', 20)->nullable();
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
        Schema::dropIfExists('game_play_logs');
    }
};
