<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblPatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_patients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('address');
            $table->string('phone');
            $table->date('date_of_birth');
            $table->string('gender');
            $table->string('avatar')
                ->default('http://150.95.104.237/assets/images/avatar/default_avatar.jpg');
            $table->integer('district_id')->unsigned();
            $table->timestamps();

            $table->foreign('district_id')->references('id')->on('tbl_districts');
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
        Schema::dropIfExists('tbl_patients');
        Schema::enableForeignKeyConstraints();
    }
}
