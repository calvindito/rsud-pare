<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmergencyDepartmentActionLimitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emergency_department_action_limits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emergency_department_id')->nullable();
            $table->unsignedBigInteger('action_id')->nullable();
            $table->integer('limit')->default(2);
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
        Schema::dropIfExists('emergency_department_action_limits');
    }
}
