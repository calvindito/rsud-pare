<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionMedicalNonOperativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('action_medical_non_operatives', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_type_id')->nullable();
            $table->string('code')->unique();
            $table->string('name')->nullable();
            $table->double('hospital_service')->nullable();
            $table->integer('doctor_operating')->nullable();
            $table->integer('doctor_anesthetist')->nullable();
            $table->integer('nurse_operating_room')->nullable();
            $table->integer('nurse_anesthetist')->nullable();
            $table->double('total')->nullable();
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
        Schema::dropIfExists('action_medical_non_operatives');
    }
}
