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
            $table->integer('medicine_id');
            $table->integer('treatment_detail_id');
            $table->integer('quantity');
            $table->primary(array('medicine_id', 'treatment_detail_id'),'medicine_of_detail');
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
        Schema::dropIfExists('tbl_medicines_quantity');
    }
}
