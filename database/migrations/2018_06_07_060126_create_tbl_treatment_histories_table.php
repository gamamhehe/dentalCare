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
            $table->dateTime('create_date');
            $table->dateTime('finish_date');
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
