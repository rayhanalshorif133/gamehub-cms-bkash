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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('banner')->nullable();
            $table->unsignedBigInteger('game_id')->nullable();
            $table->string('game_keyword')->nullable();
            $table->double('amount', 8, 2)->nullable();
            $table->integer('participation')->default(0)->nullable();
            $table->date('start_date')->nullable();
            $table->time('start_time', 6)->nullable();
            $table->date('end_date')->nullable();
            $table->time('end_time', 6)->nullable();
            $table->tinyInteger('status')->default(1);
            $table->text('description')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('campaigns');
    }
};
