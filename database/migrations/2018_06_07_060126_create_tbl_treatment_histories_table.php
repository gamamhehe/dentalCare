<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblTreatmentHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_treatment_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('treatment_id');
            $table->integer('patient_id');
            $table->integer('tooth_number');
            $table->string('description');
            $table->dateTime('created_date');
            $table->dateTime('finish_date')->nullable();
            $table->bigInteger('price');
            $table->bigInteger('total_price');
            $table->integer('payment_id');
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
        Schema::dropIfExists('tbl_treatment_histories');
    }
}
