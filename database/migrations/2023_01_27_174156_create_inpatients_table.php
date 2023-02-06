<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInpatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inpatients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->unsignedBigInteger('room_type_id')->nullable();
            $table->unsignedBigInteger('functional_service_id')->nullable();
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->char('type', 1)->nullable();
            $table->timestamp('date_of_entry')->nullable();
            $table->timestamp('date_of_out')->nullable();
            $table->json('observation')->nullable();
            $table->json('supervision_doctor')->nullable();
            $table->double('fee_room')->nullable();
            $table->double('fee_nursing_care')->nullable();
            $table->double('fee_nutritional_care')->nullable();
            $table->integer('fee_nutritional_care_qty')->nullable();
            $table->char('status', 1)->default(1);
            $table->char('ending', 1)->nullable();
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
        Schema::dropIfExists('inpatients');
    }
}
