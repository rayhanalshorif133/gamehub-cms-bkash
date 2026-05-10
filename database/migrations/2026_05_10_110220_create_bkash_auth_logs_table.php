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
        Schema::create('bkash_auth_logs', function (Blueprint $table) {
            $table->id();
            $table->string('mobile_number')->nullable();
            $table->text('id_token')->nullable();
            $table->date('created_date')->nullable();
            $table->time('created_time')->nullable();
            $table->time('exp_time')->nullable();
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
        Schema::dropIfExists('bkash_auth_logs');
    }
};
