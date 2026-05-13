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
        Schema::create('scores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('campaign_id')->nullable();
            $table->unsignedBigInteger('subscription_id')->nullable();
            $table->string('msisdn', 255);
            $table->integer('score')->default(0);
            $table->time('durations')->nullable();
            $table->string('game_keyword', 255);
            $table->bigInteger('status')->default(0);
            $table->string('encrypted_score', 255)->nullable();
            $table->dateTime('date_time')->nullable();
            $table->string('device_type', 255)->nullable();
            $table->string('user_mac', 255)->nullable();
            $table->string('mac', 255)->nullable();
            $table->string('message', 255)->nullable();
            $table->text('hit_url')->nullable();
            $table->timestamps();

            // Indexes for performance (Recommended for scoreboards)
            $table->index('msisdn');
            $table->index('campaign_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scores');
    }
};
