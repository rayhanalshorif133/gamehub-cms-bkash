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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable();
            $table->string('email', 255)->nullable()->unique();
            $table->string('phone', 255)->nullable()->unique();
            $table->string('image', 255)->nullable();
            $table->integer('point')->default(0);
            $table->string('mac', 255)->default('');
            $table->string('login_type', 20)->default('web');
            $table->string('attend_camp_id', 255)->nullable()->comment('has "free" or "camp_id"');
            $table->bigInteger('attend_game_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
