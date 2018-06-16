<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblAbsentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_absents', function (Blueprint $table) {
            $table->integer('staff_id');
            $table->integer('staff_approve_id');
            $table->dateTime('date_absent');
            $table->primary(array('staff_id', 'staff_approve_id', 'date_absent'), 'staff_date_off');
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
        Schema::dropIfExists('tbl_absents');
    }
}
