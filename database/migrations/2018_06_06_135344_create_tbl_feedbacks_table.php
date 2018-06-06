<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblFeedbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_feedbacks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('content');
            $table->integer('patient_id');
            $table->integer('treatment_detail_id');
            $table->dateTime('date_feedback');
            $table->integer('number_start');
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
        Schema::dropIfExists('tbl_feedbacks');
    }
}
