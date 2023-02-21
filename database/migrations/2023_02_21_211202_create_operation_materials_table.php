<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperationMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operation_materials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('operation_id')->nullable();
            $table->unsignedBigInteger('item_stock_id')->nullable();
            $table->integer('qty')->default(0);
            $table->double('price_purchase')->nullable();
            $table->double('price_sell')->nullable();
            $table->double('discount')->default(0);
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
        Schema::dropIfExists('operation_materials');
    }
}
