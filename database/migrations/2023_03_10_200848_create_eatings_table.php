<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eatings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->unsignedBigInteger('eating_time_id')->nullable();
            $table->unsignedBigInteger('food_id')->nullable();
            $table->string('code')->nullable();
            $table->double('fee')->nullable();
            $table->date('date')->nullable();
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
        Schema::dropIfExists('eatings');
    }
}
