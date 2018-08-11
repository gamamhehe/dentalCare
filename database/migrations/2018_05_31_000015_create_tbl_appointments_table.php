<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_appointments', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('start_time');
            $table->string('name')->nullable();
            $table->string('note')->nullable();
            $table->time('estimated_time');
            $table->integer('numerical_order');
            $table->integer('staff_id')->unsigned();
            $table->string('phone');
            $table->boolean('status')->default(0);
            $table->timestamps();

            $table->foreign('phone')->references('phone')->on('tbl_users');
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
        Schema::dropIfExists('tbl_appointments');
        Schema::enableForeignKeyConstraints();
    }
}
