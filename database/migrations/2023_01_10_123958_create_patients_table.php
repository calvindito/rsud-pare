<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->unsignedBigInteger('religion_id')->nullable();
            $table->unsignedBigInteger('place_birth_id')->nullable();
            $table->unsignedBigInteger('patiend_group_id');
            $table->unsignedBigInteger('district_id')->nullable();
            $table->string('number')->unique();
            $table->string('number_old')->nullable();
            $table->string('name');
            $table->text('address')->nullable();
            $table->string('place_birth')->nullable();
            $table->string('data_birth')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('phone')->nullable();
            $table->char('identity_type', 1)->nullable();
            $table->string('identity_number')->nullable();
            $table->string('marital_status')->nullable();
            $table->double('birth_weight')->nullable();
            $table->string('parent_name')->nullable();
            $table->string('partner_name')->nullable();
            $table->timestamps();
            $table->softDeletes('deleted_at');
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
