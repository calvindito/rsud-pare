<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudgetHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('budget_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('status')->nullable();
            $table->text('reason')->nullable();
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
        Schema::dropIfExists('budget_histories');
    }
}
