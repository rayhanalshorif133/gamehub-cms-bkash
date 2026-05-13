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
        Schema::create('boosts', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('desc', 255)->nullable();
            $table->string('type', 100);
            $table->bigInteger('score_up')->default(1);
            $table->decimal('amount', 10, 2);
            $table->integer('validity')->comment('second');
            $table->string('status', 50)->default('active');
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
        Schema::dropIfExists('boosts');
    }
};
