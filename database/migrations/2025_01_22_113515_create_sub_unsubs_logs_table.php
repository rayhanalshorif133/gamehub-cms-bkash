<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_unsubs_logs', function (Blueprint $table) {
            $table->id();
            $table->string('msisdn');
            $table->unsignedBigInteger('subscription_id')->nullable();
            $table->string('payment_id')->nullable();
            $table->string('type')->default('subs');
            $table->string('keyword')->nullable();
            $table->bigInteger('status')->default(0);
            $table->string('message')->default('ok');
            $table->date('date')->default(today());
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
        Schema::dropIfExists('sub_unsubs_logs');
    }
};
