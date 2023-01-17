<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('code_item')->unique();
            $table->string('code_type')->unique();
            $table->string('item_name')->nullable();
            $table->string('generic_name')->nullable();
            $table->string('power')->nullable();
            $table->string('power_unit')->nullable();
            $table->string('unit')->nullable();
            $table->string('inventory')->nullable();
            $table->string('bir')->nullable();
            $table->string('non_gen')->nullable();
            $table->string('oakrl')->nullable();
            $table->string('chronic')->nullable();
            $table->integer('stock')->nullable();
            $table->integer('stock_min')->nullable();
            $table->double('price')->nullable();
            $table->double('price_purchase')->nullable();
            $table->double('price_netto')->nullable();
            $table->double('discount')->nullable();
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
        Schema::dropIfExists('medicines');
    }
}