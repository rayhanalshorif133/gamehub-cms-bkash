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
        Schema::create('subs_logs', function (Blueprint $table) {
            $table->id();
            $table->string('msisdn');
            $table->unsignedBigInteger('subscription_id')->nullable();
            $table->string('payment_id')->nullable();
            $table->string('type')->default('subs');
            $table->string('keyword')->nullable();
            $table->decimal('amount', 10, 2)->default(0);
            $table->bigInteger('status')->default(0);
            $table->string('message')->default('ok');
            $table->date('date')->default(today());
            $table->json('response')->nullable();
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
        Schema::dropIfExists('subs_logs');
    }
};
