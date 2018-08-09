<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblTreatmentImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_treatment_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('treatment_detail_id')->unsigned();
            $table->string('image_link');
            $table->dateTime('created_date');
            $table->timestamps();
            $table->foreign('treatment_detail_id')->references('id')->on('tbl_treatment_details');
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
        Schema::dropIfExists('tbl_treatment_images');
        Schema::enableForeignKeyConstraints();
    }
}
