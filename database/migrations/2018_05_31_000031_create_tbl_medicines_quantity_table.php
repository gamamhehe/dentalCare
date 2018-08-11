<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblMedicinesQuantityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_medicines_quantity', function (Blueprint $table) {
            $table->integer('medicine_id')->unsigned();
            $table->integer('treatment_detail_id')->unsigned();
            $table->integer('quantity');
            $table->primary(array('medicine_id', 'treatment_detail_id'),'medicine_of_detail');
            $table->timestamps();

            $table->foreign('medicine_id')->references('id')->on('tbl_medicines');
            $table->foreign('treatment_detail_id')->references('id')->on('tbl_treatment_details');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('tbl_medicines_quantity');
        Schema::enableForeignKeyConstraints();
    }
}
