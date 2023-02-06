<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInpatientServicesTable extends Migration
{
    /**
     * Run the migrations.
     *medical_service_id
     * @return void
     */
    public function up()
    {
        Schema::create('inpatient_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inpatient_id')->nullable();
            $table->unsignedBigInteger('medical_service_id')->nullable();
            $table->json('emergency_care')->nullable();
            $table->json('hospitalization')->nullable();
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
        Schema::dropIfExists('inpatient_services');
    }
}
