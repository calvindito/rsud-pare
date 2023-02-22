<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDispensaryItemStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dispensary_item_stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dispensary_item_id')->nullable();
            $table->date('expired_date')->nullable();
            $table->integer('qty')->default(0);
            $table->double('price_purchase')->nullable();
            $table->double('price_sell')->nullable();
            $table->double('discount')->default(0);
            $table->char('type', 1)->nullable();
            $table->char('status', 1)->nullable();
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
        Schema::dropIfExists('dispensary_item_stocks');
    }
}
