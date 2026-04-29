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
            $table->unsignedBigInteger('campaign_id')->nullable()->constrained();
            $table->unsignedBigInteger('subscription_id')->nullable()->constrained();
            $table->string('msisdn');
            $table->string('score');
            $table->string('game_keyword');
            $table->string('status')->default('1');
            $table->string('encrypted_score')->nullable();
            $table->dateTime('date_time')->nullable();
            $table->string('device_type')->nullable();
            $table->string('user_mac')->nullable();
            $table->string('mac')->nullable();
            $table->string('message')->nullable();
            $table->text('hit_url')->nullable();
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
        Schema::dropIfExists('scores');
    }
};
