<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblTreatmentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_treatment_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('treatment_history_id')->unsigned();
            $table->string('note')->nullable();
            $table->integer('staff_id')->unsigned();
            $table->dateTime('created_date');
            $table->timestamps();

            $table->foreign('treatment_history_id')->references('id')->on('tbl_treatment_histories');
            $table->foreign('staff_id')->references('id')->on('tbl_staffs');
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
        Schema::dropIfExists('tbl_treatment_details');
        Schema::enableForeignKeyConstraints();
    }
}
