<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmergencyDepartmentNursingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emergency_department_nursings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emergency_department_id')->nullable();
            $table->unsignedBigInteger('action_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
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
        Schema::dropIfExists('emergency_department_nursings');
    }
}
