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
        Schema::create('tbl_staffs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('address');
            $table->integer('district_id')->unsigned();
            $table->string('degree')->nullable();
            $table->string('description')->nullable();
            $table->date('date_of_birth');
            $table->string('phone');
            $table->string('gender');
            $table->string('email')->nullable();
            $table->string('avatar')
                ->default('http://150.95.104.237/assets/images/avatar/default_avatar.jpg');
            $table->timestamps();

            $table->foreign('district_id')->references('id')->on('tbl_districts');
            $table->foreign('phone')->references('phone')->on('tbl_users');
        });
    }

    /**
     * Reverse the migrations.
     *a
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('tbl_staffs');
        Schema::enableForeignKeyConstraints();
    }
}
