<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionEmergencyCaresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('action_emergency_cares', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->double('hospital_service')->nullable();
            $table->double('service_doctor')->nullable();
            $table->double('service_nursing_care')->nullable();
            $table->double('fee')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('action_emergency_cares');
    }
}
