<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblTreatmentHistorySymptomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_treatment_history_symptoms', function (Blueprint $table) {
            $table->integer('symptom_id')->unsigned();
            $table->integer('treatment_history_id')->unsigned();
            $table->timestamps();

            $table->foreign('symptom_id')->references('id')->on('tbl_symptoms');
            $table->foreign('treatment_history_id')->references('id')->on('tbl_treatment_histories');
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
        Schema::dropIfExists('tbl_treatment_history_symptoms');
        Schema::enableForeignKeyConstraints();
    }
}
