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
            $table->integer('treatment_detail_id');
            $table->integer('step_id');
            $table->string('description');
            $table->primary(array('treatment_detail_id', 'treatment_step_id'), 'detail_of_step');
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
        Schema::dropIfExists('tbl_treatment_detail_steps');
    }
}
