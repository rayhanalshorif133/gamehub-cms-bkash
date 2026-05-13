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
        Schema::create('prize_distributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prize_id')->constrained('prizes')->onDelete('cascade');
            $table->integer('rank_min');
            $table->integer('rank_max');
            $table->string('prize_label', 255)->default('scorer');
            $table->decimal('amount', 15, 2);
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
        Schema::dropIfExists('prize_distributions');
    }
};
