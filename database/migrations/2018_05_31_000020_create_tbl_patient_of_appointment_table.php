<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblPatientOfAppointmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_patient_of_appointment', function (Blueprint $table) {
            $table->integer('appointment_id')->unsigned();
            $table->integer('patient_id')->unsigned();
            $table->primary(array('appointment_id', 'patient_id'));
            $table->timestamps();

            $table->foreign('appointment_id')->references('id')->on('tbl_appointments');
            $table->foreign('patient_id')->references('id')->on('tbl_patients');
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
        Schema::dropIfExists('tbl_patient_of_appointment');
        Schema::enableForeignKeyConstraints();
    }
}
