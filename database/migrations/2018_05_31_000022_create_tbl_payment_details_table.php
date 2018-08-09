<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblPaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_payment_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('payment_id')->unsigned();
            $table->integer('staff_id')->unsigned();
            $table->dateTime('date_create')->nullable();
            $table->bigInteger('received_money');
            $table->timestamps();
            $table->foreign('staff_id')->references('id')->on('tbl_staffs');
            $table->foreign('payment_id')->references('id')->on('tbl_payments');
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
        Schema::dropIfExists('tbl_payment_details');
        Schema::enableForeignKeyConstraints();
    }
}
