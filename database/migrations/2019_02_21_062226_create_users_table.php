<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
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
            $table->string('phone')->nullable();
			$table->string('email')->nullable();
            $table->string('phone_verify')->nullable();
            $table->string('name');
			$table->string('lname')->nullable();
            $table->string('day')->nullable();
            $table->string('month')->nullable();
            $table->string('year')->nullable();
            $table->string('gender')->nullable();
            $table->integer('user_id');
            $table->string('image')->nullable();
            $table->string('password')->nullable();
            $table->string('token')->nullable();
            $table->string('facebook_id')->nullable();
            $table->boolean('status')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
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
}
