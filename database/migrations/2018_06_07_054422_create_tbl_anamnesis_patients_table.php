<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblAnamnesisPatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_anamnesis_patients', function (Blueprint $table) {
            $table->integer('patient_id');
            $table->integer('anamnesis_id');
            $table->string('description')->nullable();
            $table->primary(array('patient_id', 'anamnesis_id'));
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
        Schema::dropIfExists('tbl_anamnesis_patients');
    }
}
