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
            $table->string('phone')->unique()->nullable();
			$table->string('email')->unique()->nullable();
            $table->string('phone_verify')->nullable();
            $table->string('name');
			$table->string('lname')->nullable();
            $table->string('day')->nullable();
            $table->string('month')->nullable();
            $table->string('year')->nullable();
            $table->enum('gender',['male','female']);
            $table->string('user_id')->unique();
            $table->string('image')->nullable();
            $table->string('password')->nullable();
            $table->string('token')->nullable();
            $table->string('facebook_id')->nullable();
            $table->integer('logincount')->default(0);
            $table->boolean('status')->default(0);
            $table->longText('profile_general_biography')->nullable();
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
