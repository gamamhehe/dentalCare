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
            $table->increments('id');
            $table->integer('staff_id');
            $table->integer('staff_approve_id')->default(0);
            $table->date('date_absent');
            $table->unique(array('staff_id', 'staff_approve_id', 'date_absent'), 'staff_date_off');
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
