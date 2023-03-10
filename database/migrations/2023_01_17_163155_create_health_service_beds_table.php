<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHealthServiceBedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('health_service_beds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_type_id')->nullable();
            $table->unsignedBigInteger('functional_service_id')->nullable();
            $table->integer('qty_man')->nullable();
            $table->integer('qty_woman')->nullable();
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
        Schema::dropIfExists('health_service_beds');
    }
}
