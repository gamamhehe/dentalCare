<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblUserHasRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_user_has_role', function (Blueprint $table) {
            $table->string('phone');
            $table->integer('role_id')->unsigned();
            $table->date('start_time');
            $table->date('end_time')->nullable();
            $table->primary(array('phone', 'role_id'));
            $table->timestamps();

            $table->foreign('phone')->references('phone')->on('tbl_users');
            $table->foreign('role_id')->references('id')->on('tbl_roles');
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
        Schema::dropIfExists('tbl_user_has_role');
        Schema::enableForeignKeyConstraints();
    }
}
