<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInpatientNonOperativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inpatient_non_operatives', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inpatient_id')->nullable();
            $table->unsignedBigInteger('action_non_operative_id')->nullable();
            $table->double('emergency_care')->nullable();
            $table->double('hospitalization')->nullable();
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
        Schema::dropIfExists('inpatient_non_operatives');
    }
}
