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
            $table->bigInteger('paid')->default(0);
            $table->bigInteger('total_price');
            $table->string('phone');
            $table->tinyInteger('status')->default(0);
            $table->timestamps();

            $table->foreign('phone')->references('phone')->on('tbl_users');
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
        Schema::dropIfExists('tbl_payments');
        Schema::enableForeignKeyConstraints();
    }
}
