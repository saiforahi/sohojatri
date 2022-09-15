<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brand_id');
            $table->foreign('brand_id')->references('id')->on('car_brands');
            $table->string('model');
            $table->string('number_plate');
            $table->string('car_image1');
            $table->string('car_image2');
            $table->string('fuel');
            $table->string('kilometers');
            $table->string('car_type')->nullable();
            $table->string('registration_year');
            $table->string('model_year');
            $table->string('user_id');
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('cars');
    }
}
