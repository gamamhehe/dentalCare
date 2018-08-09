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
            $table->integer('patient_id')->unsigned();
            $table->integer('anamnesis_id')->unsigned();
            $table->string('description')->nullable();
            $table->primary(array('patient_id', 'anamnesis_id'));
            $table->timestamps();

            $table->foreign('patient_id')->references('id')->on('tbl_patients');
            $table->foreign('anamnesis_id')->references('id')->on('tbl_anamnesis_catalogs');
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
        Schema::dropIfExists('tbl_anamnesis_patients');
        Schema::enableForeignKeyConstraints();
    }
}
