<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperatingRoomActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operating_room_actions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_type_id')->nullable();
            $table->unsignedBigInteger('operating_room_action_type_id')->nullable();
            $table->unsignedBigInteger('operating_room_group_id')->nullable();
            $table->double('fee_hospital_service')->nullable();
            $table->double('fee_doctor_operating_room')->nullable();
            $table->double('fee_doctor_anesthetist')->nullable();
            $table->double('fee_nurse_operating_room')->nullable();
            $table->double('fee_nurse_anesthetist')->nullable();
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('operating_room_actions');
    }
}
