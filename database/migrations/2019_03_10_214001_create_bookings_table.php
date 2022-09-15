<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->string('tracking');
            $table->integer('seat');
            $table->string('message',9999)->nullable();
            $table->string('promo_code')->nullable();
            $table->integer('discount')->nullable();
            $table->integer('fine')->nullable();
            $table->integer('corporate')->nullable();
            $table->integer('amount');
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('bookings');
    }
}
