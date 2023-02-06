<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInpatientOthersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inpatient_others', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inpatient_id')->nullable();
            $table->unsignedBigInteger('action_other_id')->nullable();
            $table->double('emergency_care')->nullable();
            $table->double('hospitalization')->nullable();
            $table->integer('hospitalization_qty')->nullable();
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
        Schema::dropIfExists('inpatient_others');
    }
}
