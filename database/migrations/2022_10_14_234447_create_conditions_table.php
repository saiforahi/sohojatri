<?php

use App\Models\Condition;
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
        Schema::create('conditions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        Condition::create([
            'name'=>'Non-smoking'
        ]);
        Condition::create([
            'name'=>"Access to driver's phone number"
        ]);
        Condition::create([
            'name'=>"Air conditioning"
        ]);
        Condition::create([
            'name'=>"Trunk space: backpack size only"
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conditions');
    }
};
