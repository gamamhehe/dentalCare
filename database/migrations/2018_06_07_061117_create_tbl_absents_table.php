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
            $table->integer('staff_approve_id');
            $table->integer('request_absent_id');
            $table->longText('message_from_staff')->nullabe();
            $table->primary(array('staff_approve_id', 'request_absent_id'), 'staff_approve');
            $table->dateTime('created_time');
            $table->boolean('is_approved')->default(true);
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
