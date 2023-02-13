<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_banks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chart_of_account_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->double('nominal')->nullable();
            $table->date('date')->nullable();
            $table->char('type', 1)->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('cash_banks');
    }
}
