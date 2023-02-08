<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRadiologyRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('radiology_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->unsignedBigInteger('radiology_id')->nullable();
            $table->nullableMorphs('radiology_requestable', 'radiology_requestable_type_id');
            $table->string('image')->nullable();
            $table->timestamp('date_of_request')->nullable();
            $table->string('clinical')->nullable();
            $table->boolean('critical')->nullable();
            $table->text('expertise')->nullable();
            $table->double('consumables')->nullable();
            $table->double('hospital_service')->nullable();
            $table->double('service')->nullable();
            $table->double('fee')->nullable();
            $table->char('status', 1)->default(1);
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
        Schema::dropIfExists('radiology_requests');
    }
}
