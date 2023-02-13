<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_fees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lab_item_id')->nullable();
            $table->unsignedBigInteger('class_type_id')->nullable();
            $table->double('consumables')->nullable();
            $table->double('hospital_service')->nullable();
            $table->double('service')->nullable();
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
        Schema::dropIfExists('lab_fees');
    }
}
