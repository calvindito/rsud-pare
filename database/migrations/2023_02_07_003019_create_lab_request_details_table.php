<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabRequestDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_request_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lab_request_id')->nullable();
            $table->unsignedBigInteger('lab_item_id')->nullable();
            $table->unsignedBigInteger('lab_item_parent_id')->nullable();
            $table->unsignedBigInteger('lab_item_condition_id')->nullable();
            $table->double('consumables')->nullable();
            $table->double('hospital_service')->nullable();
            $table->double('service')->nullable();
            $table->string('result')->nullable();
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
        Schema::dropIfExists('lab_request_details');
    }
}
