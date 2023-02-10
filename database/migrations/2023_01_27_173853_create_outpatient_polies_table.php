<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutpatientPoliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outpatient_polies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('outpatient_id')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->timestamp('date_of_out')->nullable();
            $table->char('status', 1)->nullable();
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
        Schema::dropIfExists('outpatient_polies');
    }
}
