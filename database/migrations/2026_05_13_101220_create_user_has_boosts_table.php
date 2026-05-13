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
        Schema::create('user_has_boosts', function (Blueprint $table) {
            $table->id();
            $table->string('msisdn', 20);
            $table->string('keyword', 100)->nullable();
            $table->unsignedInteger('camp_id')->nullable();
            $table->unsignedInteger('boost_id')->nullable();
            $table->integer('validity')->nullable()->comment('second');
            $table->timestamp('start_time')->nullable();
            $table->timestamp('expire_time')->nullable();
            $table->date('date')->nullable();
            $table->timestamps();

            // Recommended indexes for performance
            $table->index('msisdn');
            $table->index('boost_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_has_boosts');
    }
};
