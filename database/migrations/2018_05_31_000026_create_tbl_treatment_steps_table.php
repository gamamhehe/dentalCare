<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblTreatmentStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_treatment_steps', function (Blueprint $table) {
            $table->integer('step_id')->unsigned();
            $table->integer('treatment_id')->unsigned();
            $table->primary(array('step_id', 'treatment_id'));
            $table->timestamps();

            $table->foreign('step_id')->references('id')->on('tbl_steps');
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
        Schema::dropIfExists('tbl_treatment_steps');
        Schema::enableForeignKeyConstraints();
    }
}
