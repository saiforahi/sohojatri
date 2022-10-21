<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePopularRidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('popular_rides', function (Blueprint $table) {
            $table->increments('id');
            $table->string('s_lat');
            $table->string('s_lng');
            $table->string('s_location');
            $table->string('e_lat');
            $table->string('e_lng');
            $table->string('e_location');
            $table->double('payment',8,2);
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
        Schema::dropIfExists('popular_rides');
    }
}
