<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabItemParentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_item_parents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('lab_item_id')->nullable();
            $table->char('level', 1)->nullable();
            $table->double('limit_lower')->nullable();
            $table->double('limit_critical_lower')->nullable();
            $table->double('limit_upper')->nullable();
            $table->double('limit_critical_upper')->nullable();
            $table->double('limit_lower_patient')->nullable();
            $table->double('limit_critical_lower_patient')->nullable();
            $table->double('limit_upper_patient')->nullable();
            $table->double('limit_critical_upper_patient')->nullable();
            $table->boolean('dropdown')->default(true);
            $table->string('method')->nullable();
            $table->string('unit')->nullable();
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('lab_item_parents');
    }
}
