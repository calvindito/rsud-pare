<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmergencyDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emergency_departments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->unsignedBigInteger('functional_service_id')->nullable();
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->unsignedBigInteger('dispensary_id')->nullable();
            $table->char('type', 1)->nullable();
            $table->json('observation')->nullable();
            $table->json('supervision_doctor')->nullable();
            $table->timestamp('date_of_entry')->nullable();
            $table->timestamp('date_of_out')->nullable();
            $table->boolean('paid')->default(0);
            $table->char('status', 1)->default(1);
            $table->char('ending', 1)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emergency_departments');
    }
}
