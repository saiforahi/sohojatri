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
        Schema::create('validations', function (Blueprint $table) {
            $table->id();
            $table->string('fk_user_id');
            $table->string('destination');
            $table->integer('code');
            $table->string('validation_type');
            $table->timestamps();
            $table->foreign('fk_user_id')->references('user_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('validations');
    }
};
