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
            $table->integer('treatment_id')->unsigned();
            $table->integer('patient_id')->unsigned();
            $table->integer('tooth_number')->unsinged();
            $table->string('description');
            $table->dateTime('created_date');
            $table->dateTime('finish_date')->nullable();
            $table->bigInteger('price');
            $table->bigInteger('total_price');
            $table->integer('payment_id')->unsigned();
            $table->timestamps();


            $table->foreign('patient_id')->references('id')->on('tbl_patients');
            $table->foreign('payment_id')->references('id')->on('tbl_payments');
            $table->foreign('tooth_number')->references('tooth_number')->on('tbl_tooths');
            $table->foreign('treatment_id')->references('id')->on('tbl_treatments');
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
        Schema::dropIfExists('tbl_treatment_histories');
        Schema::enableForeignKeyConstraints();
    }
}
