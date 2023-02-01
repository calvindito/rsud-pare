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
            $table->unsignedBigInteger('pharmacy_production_id')->nullable();
            $table->unsignedBigInteger('operating_room_anesthetist_id')->nullable();
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->nullableMorphs('operationable');
            $table->timestamp('date_of_entry')->nullable();
            $table->string('diagnosis')->nullable();
            $table->boolean('specimen')->default(false);
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
        Schema::dropIfExists('operations');
    }
}