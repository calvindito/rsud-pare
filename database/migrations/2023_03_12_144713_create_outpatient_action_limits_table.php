<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutpatientActionLimitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outpatient_action_limits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('outpatient_id')->nullable();
            $table->unsignedBigInteger('unit_action_id')->nullable();
            $table->integer('limit')->default(2);
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
        Schema::dropIfExists('outpatient_action_limits');
    }
}
