<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('treatment_history_id');
            $table->integer('patient_id');
            $table->integer('treatment_id');
            $table->dateTime('date_pay');
            $table->bigInteger('prepaid');
            $table->bigInteger('note_payable');
            $table->integer('reception_id');
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
        Schema::dropIfExists('tbl_payments');
    }
}
