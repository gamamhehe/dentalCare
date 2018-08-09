<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblTreatmentDetailStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_treatment_detail_steps', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('treatment_detail_id')->unsigned();
            $table->integer('step_id')->unsigned();
            $table->timestamps();

            $table->foreign('treatment_detail_id')->references('id')->on('tbl_treatment_details');
            $table->foreign('step_id')->references('id')->on('tbl_steps');
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
        Schema::dropIfExists('tbl_treatment_detail_steps');
        Schema::enableForeignKeyConstraints();
    }
}
