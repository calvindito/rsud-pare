<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('province_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('district_id')->nullable();
            $table->unsignedBigInteger('village_id')->nullable();
            $table->unsignedBigInteger('religion_id')->nullable();
            $table->unsignedBigInteger('place_of_birth')->nullable();
            $table->string('code')->unique();
            $table->string('identity_number')->nullable();
            $table->string('name')->nullable();
            $table->char('gender', 1)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->text('address')->nullable();
            $table->string('tribe')->nullable();
            $table->double('weight')->nullable();
            $table->text('blood_group')->nullable();
            $table->char('marital_status', 1)->nullable();
            $table->string('job')->nullable();
            $table->string('phone')->nullable();
            $table->string('parent_name')->nullable();
            $table->string('partner_name')->nullable();
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
        Schema::dropIfExists('patients');
    }
}
