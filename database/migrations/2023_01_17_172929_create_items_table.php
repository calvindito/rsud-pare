<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('installation_id')->nullable();
            $table->unsignedBigInteger('distributor_id')->nullable();
            $table->unsignedBigInteger('item_unit_id')->nullable();
            $table->string('code')->nullable();
            $table->string('code_t')->nullable();
            $table->string('code_type')->nullable();
            $table->string('name')->nullable();
            $table->string('name_generic')->nullable();
            $table->string('power')->nullable();
            $table->string('power_unit')->nullable();
            $table->string('unit')->nullable();
            $table->string('inventory')->nullable();
            $table->string('bir')->nullable();
            $table->string('non_generic')->nullable();
            $table->string('nar')->nullable();
            $table->string('oakrl')->nullable();
            $table->string('chronic')->nullable();
            $table->char('type', 1)->nullable();
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
        Schema::dropIfExists('items');
    }
}
