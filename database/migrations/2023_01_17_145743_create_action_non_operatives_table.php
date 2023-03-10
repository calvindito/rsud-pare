<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionNonOperativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('action_non_operatives', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_type_id')->nullable();
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->double('hospital_service')->nullable();
            $table->double('doctor_operating')->nullable();
            $table->double('doctor_anesthetist')->nullable();
            $table->double('nurse_operating_room')->nullable();
            $table->double('nurse_anesthetist')->nullable();
            $table->double('total')->nullable();
            $table->double('fee')->nullable();
            $table->double('emergency_care')->nullable();
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
        Schema::dropIfExists('action_non_operatives');
    }
}
