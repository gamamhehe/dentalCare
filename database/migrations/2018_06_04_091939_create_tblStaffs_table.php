<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblStaffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblStaffs', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('name');
            $table->string('specialty');
            $table->date('dateOfBirth');
            $table->string('phone');
            $table->string('gender');
            $table->string('avatar');
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
        Schema::dropIfExists('tblStaffs');
    }
}
