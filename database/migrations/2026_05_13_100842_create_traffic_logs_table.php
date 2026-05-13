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
        Schema::create('traffic_logs', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_id', 50)->default('NULL')->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('msisdn', 20)->nullable();
            $table->boolean('is_paid')->default(false);
            $table->string('url', 255)->default('');
            $table->boolean('send_notify')->default(false);
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
        Schema::dropIfExists('traffic_logs');
    }
};
