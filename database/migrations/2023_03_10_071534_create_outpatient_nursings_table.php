<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutpatientNursingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outpatient_nursings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('outpatient_id')->nullable();
            $table->unsignedBigInteger('unit_action_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->double('consumables')->nullable();
            $table->double('hospital_service')->nullable();
            $table->double('service')->nullable();
            $table->double('fee')->nullable();
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
        Schema::dropIfExists('outpatient_nursings');
    }
}
