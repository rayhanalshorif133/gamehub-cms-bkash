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
        Schema::create('charge_logs', function (Blueprint $table) {
            $table->id();
            $table->string('payment_id', 255)->nullable();
            $table->unsignedBigInteger('campaign_id')->nullable();
            $table->string('msisdn', 255)->nullable();
            $table->string('keyword', 255)->nullable();
            $table->string('amount', 255)->nullable();
            $table->string('type', 255)->nullable();
            $table->date('charge_date')->default(DB::raw('(CURRENT_DATE)'));
            $table->date('expire_date')->default(DB::raw('(CURRENT_DATE)'));
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
        Schema::dropIfExists('charge_logs');
    }
};
