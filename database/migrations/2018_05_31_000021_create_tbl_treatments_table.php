<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblTreatmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_treatments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->integer('treatment_category_id')->unsigned();
            $table->bigInteger('min_price');
            $table->bigInteger('max_price');
            $table->timestamps();

            $table->foreign('treatment_category_id')->references('id')->on('tbl_treatment_categories');
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
        Schema::dropIfExists('tbl_treatments');
        Schema::enableForeignKeyConstraints();
    }
}
