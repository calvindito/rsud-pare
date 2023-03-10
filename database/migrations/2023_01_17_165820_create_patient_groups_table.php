<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_groups', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->integer('kpid')->nullable();
            $table->string('initial')->nullable();
            $table->string('privilege_class_code')->nullable();
            $table->string('privilege_class_type')->nullable();
            $table->string('rule_code')->nullable();
            $table->string('first_number')->nullable();
            $table->boolean('contribution_assistance')->nullable();
            $table->boolean('car_free_ambulance')->nullable();
            $table->boolean('car_free_corpse')->nullable();
            $table->string('code_member')->nullable();
            $table->string('code_membership')->nullable();
            $table->boolean('employeeable')->default(0);
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
        Schema::dropIfExists('patient_groups');
    }
}
