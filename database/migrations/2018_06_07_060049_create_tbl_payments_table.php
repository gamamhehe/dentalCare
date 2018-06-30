<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('prepaid')->default(0);
            $table->bigInteger('total_price');
<<<<<<< HEAD
            $table->text('phone');
            $table->boolean('is_done');
=======
            $table->integer('phone');
            $table->boolean('is_done')->default(false);
>>>>>>> UAT
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
        Schema::dropIfExists('tbl_payments');
    }
}
