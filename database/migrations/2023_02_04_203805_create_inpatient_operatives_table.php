<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInpatientOperativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inpatient_operatives', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inpatient_id')->nullable();
            $table->unsignedBigInteger('action_operative_id')->nullable();
            $table->double('nominal')->nullable();
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
        Schema::dropIfExists('inpatient_operatives');
    }
}
