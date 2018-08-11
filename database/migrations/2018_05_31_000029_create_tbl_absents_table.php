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
            $table->integer('staff_approve_id')->unsigned();
            $table->integer('request_absent_id')->unsigned();
            $table->longText('message_from_staff')->nullabe();
            $table->primary(array('staff_approve_id', 'request_absent_id'), 'staff_approve');
            $table->dateTime('created_time');
            $table->boolean('is_approved')->default(true);
            $table->timestamps();


            $table->foreign('staff_approve_id')->references('id')->on('tbl_staffs');
            $table->foreign('request_absent_id')->references('id')->on('tbl_request_absents');
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
        Schema::dropIfExists('tbl_absents');
        Schema::enableForeignKeyConstraints();
    }
}
