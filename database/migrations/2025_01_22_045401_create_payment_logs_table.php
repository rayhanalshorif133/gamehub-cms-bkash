<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('payment_logs', function (Blueprint $table) {
            $table->id();
            $table->string('msisdn', 20)->nullable();
            $table->string('campaign_id', 2)->nullable();
            $table->string('status', 50)->nullable();
            $table->string('payment_id', 255)->nullable();
            $table->string('msg', 255)->nullable();
            $table->decimal('amount', 10, 2)->nullable();
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
        Schema::dropIfExists('payment_creates');
    }
};
