<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->unsignedBigInteger('operating_room_action_id')->nullable();
            $table->unsignedBigInteger('functional_service_id')->nullable();
            $table->unsignedBigInteger('operating_room_anesthetist_id')->nullable();
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->unsignedBigInteger('doctor_operation_id')->nullable();
            $table->nullableMorphs('operationable');
            $table->timestamp('date_of_entry')->nullable();
            $table->timestamp('date_of_out')->nullable();
            $table->string('diagnosis')->nullable();
            $table->boolean('specimen')->default(0);
            $table->double('hospital_service')->nullable();
            $table->double('doctor_operating_room')->nullable();
            $table->double('doctor_anesthetist')->nullable();
            $table->double('nurse_operating_room')->nullable();
            $table->double('nurse_anesthetist')->nullable();
            $table->double('material')->nullable();
            $table->double('monitoring')->nullable();
            $table->double('nursing_care')->nullable();
            $table->char('status', 1)->default(1);
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
        Schema::dropIfExists('operations');
    }
}
